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
        form_valid:true,
        fields:null,
        init:function( el )
        {
          if( el[0] != undefined )
          {
            this.el           = el;
            this.action       = el.data('action');
            this.pre_callback = el.data('pre-callback');
            this.fields       = this.el.find('[data-validate]')
          }

          $.ajax_overlay.init( $(this.el ).find('[data-ajax-overlay]') );
        },
        make_request: function( instance )
        {
          if( this.fields.length > 0 )
            $.validation.clear_errors( this );

          $.validation.validate_form( instance );
          $(document).trigger('ajax_overlay:show');

          var formData = this.el.serialize();

          if( this.form_valid )
          {
            $.ajax( ajaxurl, {
              processData:false,
              type: "POST",
              data: formData,
              success:function( response )
              {
                setTimeout( function ()
                {
                  $( document ).trigger( 'ajax_overlay:hide' );
                }, 1000 );

                var newData = $.parseJSON( response );

                console.log( newData )

                if ( $.callback_bank.callbacks.hasOwnProperty( newData.callback ) )
                  $.callback_bank.callbacks[ newData.callback ]( newData );
              }
            })
          }
          else
          {
            $( document ).trigger( 'ajax_overlay:hide' );
          }
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
      },
      validation:{
        el:'',
        validate_form:function( form )
        {
          var result = '';

          if( form.fields.length > 1 )
          {
            form.fields.each( function()
            {
              result = $.validation.validate_field( $(this) );
            })
          }
          else
          {
            result = true;
          }

          form.form_valid = result;
        },
        validate_field:function( field )
        {
          var pattern = field.data('validate' ),
              regex   = new RegExp( pattern, 'gi' ),
              val     = field.val(),
              result  = true;

          if( val )
          {
            result = regex.test( val );

            !result ? $.validation.fire_error( field ) : '' ;
          }
          else
          {
            result = false;
          }

          return result;
        },
        clear_errors:function( form )
        {
          form.fields.each(function()
          {
            $(this).removeClass('error');
            $(this).closest('li' ).find('span').remove();
          })
        },
        fire_error:function( field )
        {
          var fieldItem = field.closest('li');
              fieldItem.addClass('error');
              fieldItem.append( '<span>Please enter a valid value.</span>' )
        }
      }
    });

    $(document ).ready( function()
    {
      $(document).on( 'submit', '[data-ajax-form]', function( e )
      {
        e.preventDefault();
        $.wp_ajax.init( $(this) );
        $.wp_ajax.make_request( $.wp_ajax );
      });


    });

  })

})( jQuery, window )
