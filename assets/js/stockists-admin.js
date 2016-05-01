;( function( $, window, undefined )
{
  $(document ).ready(function()
  {
    $.extend({
      maps:{
      el:'',
      map:'',
      update_lat:'',
      update_lng:'',
      defaults:{
        center:{ lat: 32.7833, lng: -79.9333 },
        zoom:14
      },
      options:{},
      init:function( el, options, lat, lng )
      {
        this.el = el;

        this.options = $.extend( {}, this.defaults, options )
        this.map     = new google.maps.Map( el[0], this.options );

        if( this.el.data('drag') )
        {
          this.set_draggable_point();
          this.update_lat = lat
          this.update_lng = lng
        }
      },
      set_draggable_point:function()
      {
        var marker = new google.maps.Marker({
          position: this.options.center,
          map: this.map,
          draggable:true
        });

        google.maps.event.addListener( marker, 'dragend', function( event )
        {
          $.fn.maps.update_lat.val( this.getPosition().lat().toFixed(8) );
          $.fn.maps.update_lng.val( this.getPosition().lng().toFixed(8) );
        });
      },
      refresh_map:function( data )
      {
        this.options.center.lat = data.lat
        this.options.center.lng = data.lng
        this.init( this.el, this.options )
      }
    },
      wp_ajax:{
        el:'',
        action:'',
        init:function( el )
        {
          if( el[0] != undefined )
          {
            this.el           = el;
            this.action       = el.data('action');
            this.pre_callback = el.data('pre-callback');
          }

          $.ajax_overlay.init( $(this.el ).find('[data-ajax-overlay]') );
        },
        make_request: function( instance )
        {
          $(document).trigger('ajax_overlay:show');

          var formData = this.el.serializeArray(),
              data = {};

          $.each(formData, function()
          {
            if( data[this.name] !== undefined )
            {
              if( !data[this.name].push )
              {
                data[this.name] = [ data[this.name] ];
              }
              data[this.name].push( this.value || '' );
            }
            else
            {
              data[this.name] = this.value || '';
            }
          });

          data.action  = this.action;
          data.referer = data._wp_http_referer;

          if( this.pre_callback != '' && $.callback_bank.filters.hasOwnProperty( this.pre_callback ) )
            data = $.callback_bank.filters[this.pre_callback]( data );

          $.post( ajaxurl, data, function( response )
          {
            setTimeout(function()
            {
              $(document ).trigger('ajax_overlay:hide');
            }, 1000 );

            var new_data = $.parseJSON( response );

            if( $.callback_bank.callbacks.hasOwnProperty( new_data.callback ) )
              $.callback_bank.callbacks[new_data.callback]( new_data );

            typeof after_request == 'function' ? after_request( data, new_data ) : '' ;
          });


        }
      },
      callback_bank:{
      filters:
      {

      },
      callbacks:
      {

      }
    },
      ajax_overlay: {
        el:null,
        init:function( el )
        {
          this.el = el;

          $(document).on( 'ajax_overlay:show', this, function( e )
          {
            e.data.show_overlay();
          })

          $(document).on( 'ajax_overlay:hide', this, function( e )
          {
            e.data.hide_overlay();
          })
        },
        show_overlay:function()
        {
          this.el.height( this.el.parent().height() + 50 );
          this.el.addClass('processing').delay(1000).addClass('visible')
        },
        hide_overlay:function()
        {
          this.el.attr('style', '' );
          this.el.removeClass('visible' ).delay(1000 ).removeClass('processing')
        }
      }
    });

    $(document ).ready( function()
    {
      $(document ).on( 'submit', '[data-ajax-form]', function( e )
      {
        e.preventDefault();
        $.wp_ajax.init( $(this) );
        $.wp_ajax.make_request( $.wp_ajax );
      });
    });

  })

})( jQuery, window )
