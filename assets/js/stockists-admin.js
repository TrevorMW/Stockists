;( function( $, window, undefined )
{
  $(document ).ready(function()
  {
    $.extend({
      maps:{
        el:'',
        map:'',
        defaults:{
          center:{ lat:32.7833, lng:-79.9333 },
          zoom:14
        },
        options:{},
        init:function( el, options )
        {
          this.el      = el;
          this.options = $.extend( {}, this.defaults, options )
          this.map     = new google.maps.Map( el[ 0 ], this.options );

          this.set_point( this.map, this.options.center, true );
        },
        set_point:function( map, center, draggable )
        {
          var marker = new google.maps.Marker( {
            position:center,
            map:map,
            draggable:draggable
          } );

          if( draggable )
          {
            google.maps.event.addListener( marker, 'dragend', function( event )
            {
              $.maps.update_lat.val( this.getPosition().lat().toFixed( 8 ) );
              $.maps.update_lng.val( this.getPosition().lng().toFixed( 8 ) );
            });
          }
        },
        loadMaps:function()
        {
          $('[data-google-map]' ).each( function()
          {
            $.maps.init( $(this), $(this ).data('options') )
          })
        }
      },
      wp_ajax:{
        el:'',
        action:'',
        form_valid:true,
        fields:null,
        target:null,
        formData:null,
        customData:null,
        init:function( el )
        {
          if( el[0] != undefined )
          {
            this.el           = el;
            this.action       = el.data('action');
            this.pre_callback = el.data('pre-callback');
            this.target       = $('[data-'+ el.data('target') + ']');
            this.fields       = this.el.find('[data-validate]');
            this.customData   = el.data();
          }

          $.ajax_overlay.init( $(this.el).find('[data-ajax-overlay]') );
        },
        make_request: function( instance, before )
        {
          if( this.fields.length > 0 )
            $.validation.clear_errors( this );

          $.validation.validate_form( instance );
          $(document).trigger('ajax_overlay:show');

          this.formData = this.el.serialize() + '&action=' + this.action;

          if( typeof before == 'function' )
          {
            this.formData = before( this, this.formData );
          }

          if( this.form_valid )
          {
            $.ajax( ajaxurl, {
              processData:false,
              type: "POST",
              data: this.formData,
              success:function( response )
              {
                setTimeout( function ()
                {
                  $( document ).trigger( 'ajax_overlay:hide' );
                }, 1000 );

                var newData = $.parseJSON( response );

                if ( $.callback_bank.callbacks.hasOwnProperty( newData.callback ) )
                  $.callback_bank.callbacks[ newData.callback ]( newData, $.wp_ajax );
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
        callbacks:{
          loadStockistMetaForm:function( resp, inst )
          {
            if( inst.target != undefined )
            {
              var data = '';

              if( resp.status )
              {
                data = resp.data.stockist_meta_fields;
              }
              else
              {
                data = 'Could not load stockist fields. Please try again.';
              }
              inst.target.html('')
              inst.target.html( data )

              $(document).trigger('maps:load')
            }
          }
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

      $(document ).on( 'change', '[data-ajax-select]', function()
      {
        $.wp_ajax.init( $(this) );
        $.wp_ajax.target = $('[data-'+ $(this).data('target') + ']');

        $.wp_ajax.make_request( $.wp_ajax, function( inst, data )
        {
          return inst.formData + '&postID=' + inst.customData.postid;
        }, $(this) );
      })

      $(document).on( 'maps:load', function()
      {
        $.maps.loadMaps();
      })
    });

  })

})( jQuery, window )
