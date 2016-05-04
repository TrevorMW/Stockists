/**
 * Created by Trevor on 5/3/16.
 */
;(function( $, window, undefined )
{
  $(document ).ready(function()
  {
    $.extend( {
      maps:{
        el:'',
        map:'',
        update_lat:'',
        update_lng:'',
        defaults:{
          center:{ lat:32.7833, lng:-79.9333 },
          zoom:14
        },
        options:{},
        init:function( el, options, lat, lng )
        {
          this.el = el;

          this.options = $.extend( {}, this.defaults, options )
          this.map = new google.maps.Map( el[ 0 ], this.options );

          if ( this.el.data( 'drag' ) )
          {
            this.set_draggable_point();
            this.update_lat = lat
            this.update_lng = lng
          }
        },
        set_draggable_point:function()
        {
          var marker = new google.maps.Marker( {
            position:this.options.center,
            map:this.map,
            draggable:true
          } );

          google.maps.event.addListener( marker, 'dragend', function( event )
          {
            $.fn.maps.update_lat.val( this.getPosition().lat().toFixed( 8 ) );
            $.fn.maps.update_lng.val( this.getPosition().lng().toFixed( 8 ) );
          } );
        },
        refresh_map:function( data )
        {
          this.options.center.lat = data.lat
          this.options.center.lng = data.lng
          this.init( this.el, this.options )
        }
      }
    }

    var fireLoadMap = function()
    {
      $('[data-google-map]' ).each(function()
      {
        var options = {},
            lat     = '',
            lng     = '';

        $.maps.init( $(this), options, lat, lng );
      })
    }
  })

})( jQuery, window );