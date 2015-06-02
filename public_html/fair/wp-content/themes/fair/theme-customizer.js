/**
    * このファイルはテーマカスタマイザーライブプレビューをライブにします。
    * テーマ設定で 'postMessage' を指定し、ここで制御します。
    * JavaScript はコントロールからテーマ設定を取得し、 
    * jQuery を使ってページに変更を反映します。
    */
   (function($){
       // リアルタイムにサイトタイトルを変更
       wp.customize( 'blogname', function( value ) {
           value.bind( function( newval ) {
               $( '#site-title a' ).html( newval );
           } );
       } );
       // リアルタイムにキャッチフレーズを変更
       wp.customize( 'blogdescription', function( value ) {
           value.bind( function( newval ) {
               $( '.site-description' ).html( newval );
           } );
       } );
       
       // リアルタイムにサイトタイトルの色を変更
       wp.customize( 'header_textcolor', function( value ) {
           value.bind( function( newval ) {
               $('#site-title a').css('color', newval );
           } );
       } );
       
       // リアルタイムに背景色を変更
       wp.customize( 'background_color', function( value ) {
           value.bind( function( newval ) {
               $('body').css('background-color', newval );
           } );
       } );
       
       // リアルタイムにリンク色を変更
       wp.customize( 'mytheme_options[link_textcolor]', function( value ) {
           value.bind( function( newval ) {
               $('a').css('color', newval );
           } );
       } );
   })(jQuery);