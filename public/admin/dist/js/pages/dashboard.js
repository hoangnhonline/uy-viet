/*
 * Author: Abdullah A Almsaeed
 * Date: 4 Jan 2014
 * Description:
 *      This is a demo file used only for the main dashboard (index.html)
 **/

$(function () {

  "use strict";

  //Make the dashboard widgets sortable Using jquery UI

  $(".connectedSortable .box-header, .connectedSortable .nav-tabs-custom").css("cursor", "move");



  /* Morris.js Charts */


  //Fix for charts under tabs
  $('.box ul.nav a').on('shown.bs.tab', function () {
    //area.redraw();
    //donut.redraw();
    //line.redraw();
  });

});
