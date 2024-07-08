//=======================Script for selecting multiple Country========================//
$(document).ready(function () {
    // var select = $('select[multiple]');
    var submitMove = $("#contrySubmitBtn-move");
    var select = $("#Country");
    var options = select.find("option");
  
    var div = $("<div />").addClass("selectMultipleCountry");
    var active = $("<div />");
    var list = $("<ul />");
    var placeholder = select.data("placeholder");
  
    var span = $("<span />").text(placeholder).appendTo(active);
  
    options.each(function () {
      var text = $(this).text();
      if ($(this).is(":selected")) {
        active.append($("<a />").html("<em>" + text + "</em><i></i>"));
        span.addClass("hide");
      } else {
        list.append($("<li />").html(text));
      }
    });
  
    active.append($("<div />").addClass("arrow"));
    div.append(active).append(list);
  
    select.wrap(div);
  
    $(document).on("click", ".selectMultipleCountry ul li", function (e) {
      var select = $(this).parent().parent();
      var ul = $(this).parent();
      var li = $(this);
  
      var anchors = $(".selectMultipleCountry > div a");
  
      if (!select.hasClass("clicked")) {
        select.addClass("clicked");
        li.prev().addClass("beforeRemove");
        li.next().addClass("afterRemove");
        li.addClass("remove");
        var a = $("<a />")
          .addClass("notShown")
          .html("<em>" + li.text() + "</em><i></i>")
          .hide()
          .appendTo(select.children("div"));
        a.slideDown(10, function () {
          setTimeout(function () {
            a.addClass("shown");
            select.children("div").children("span").addClass("hide");
            select
              .find("option:contains(" + li.text() + ")")
              .prop("selected", true);
          }, 10);
        });
        setTimeout(function () {
          if (li.prev().is(":last-child")) {
            li.prev().removeClass("beforeRemove");
          }
          if (li.next().is(":first-child")) {
            li.next().removeClass("afterRemove");
          }
          setTimeout(function () {
            li.prev().removeClass("beforeRemove");
            li.next().removeClass("afterRemove");
          }, 200);
  
          li.slideUp(200, function () {
            li.remove();
            select.removeClass("clicked");
          });
        }, 600);
      }
  
      //==============Start To Remove whole "UL" and all "tages" in <select> except WORLDWIDE when clicked on WORLDWIDE==========By Rana=======//
  
      if (li.text() == "WORLDWIDE") {
        ul.addClass("notShown");
        for (let i = 0; i < anchors.length; i++) {
          console.log(
            "this is anchor before:",
            anchors[i].firstChild.textContent
          );
          // console.log("this is anchor before:", anchors[i].parentNode);
  
          if (anchors[i].firstChild.textContent != "WORLDWIDE") {
            console.log("This is innerhtml", $("#Country").val());
            // $('#Country').val() = "";
  
            anchors[i].setAttribute("class", "remove");
            anchors[i].setAttribute("class", "disappear");
            // $('#Country').val().dismiss;
            // anchors[i].firstChild.textContent.setAttribute("class", "notShown");
            // anchors[i].firstChild.remove();
  
            // anchors[i].firstChild.setAttribute("class", "notShown");
            // select.find('option:contains(' + anchors[i].firstChild.textContent + ')').prop('selected', false)
            anchors[i].remove();
            // anchors[i].addClass("disappear");
          }
          console.log("this is anchor after:", anchors[i].firstChild.textContent);
        }
      }
  
      //==============End To Remove whole UL when clicked on WORLDWIDE==========By Rana=======//
    });
  
    $(document).on("click", ".selectMultipleCountry > div a", function (e) {
      var select = $(this).parent().parent();
      var self = $(this);
      self.removeClass().addClass("remove");
      select.addClass("open");
      submitMove.addClass("sub-move");
      setTimeout(function () {
        self.addClass("disappear");
        setTimeout(function () {
          self.animate(
            {
              width: 0,
              height: 0,
              padding: 0,
              margin: 0,
            },
            300,
            function () {
              var li = $("<li />")
                .text(self.children("em").text())
                .addClass("notShown")
                .appendTo(select.find("ul"));
              li.slideDown(400, function () {
                li.addClass("show");
                setTimeout(function () {
                  select
                    .find("option:contains(" + self.children("em").text() + ")")
                    .prop("selected", false);
                  if (!select.find("option:selected").length) {
                    select.children("div").children("span").removeClass("hide");
                  }
                  li.removeClass();
                }, 400);
              });
              self.remove();
            }
          );
        }, 300);
      }, 100);
    });
  
    $(document).on(
      "click",
      ".selectMultipleCountry > div .arrow, .selectMultipleCountry > div span",
      function (e) {
        $(this).parent().parent().toggleClass("open");
        submitMove.toggleClass("sub-move");
        console.log("this is submit to move",submitMove);
        
      }
    );
  });
  
  
  
  
  
  //=======================Script for selecting multiple Category========================//
      $(document).ready(function() {
  
          // var select = $('select[multiple]');
          var submitMove = $("#categorySubmitBtn-move");
          var select = $('#Category');
          var options = select.find('option');
  
          var div = $('<div />').addClass('selectMultiple');
          var active = $('<div />');
          var list = $('<ul />');
          var placeholder = select.data('placeholder');
  
          var span = $('<span />').text(placeholder).appendTo(active);
  
          options.each(function() {
              var text = $(this).text();
              if ($(this).is(':selected')) {
                  active.append($('<a />').html('<em>' + text + '</em><i></i>'));
                  span.addClass('hide');
              } else {
                  list.append($('<li />').html(text));
              }
          });
  
          active.append($('<div />').addClass('arrow'));
          div.append(active).append(list);
  
          select.wrap(div);
  
          $(document).on('click', '.selectMultiple ul li', function(e) {
              var select = $(this).parent().parent();
              var ul = $(this).parent();
              var li = $(this);
  
              var anchors = $('.selectMultiple > div a');
  
  
  
  
  
              if (!select.hasClass('clicked')) {
                  select.addClass('clicked');
                  li.prev().addClass('beforeRemove');
                  li.next().addClass('afterRemove');
                  li.addClass('remove');
                  var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
                  a.slideDown(10, function() {
                      setTimeout(function() {
                          a.addClass('shown');
                          select.children('div').children('span').addClass('hide');
                          select.find('option:contains(' + li.text() + ')').prop('selected', true);
                      }, 10);
                  });
                  setTimeout(function() {
                      if (li.prev().is(':last-child')) {
                          li.prev().removeClass('beforeRemove');
                      }
                      if (li.next().is(':first-child')) {
                          li.next().removeClass('afterRemove');
                      }
                      setTimeout(function() {
                          li.prev().removeClass('beforeRemove');
                          li.next().removeClass('afterRemove');
                      }, 200);
  
                      li.slideUp(200, function() {
                          li.remove();
                          select.removeClass('clicked');
                      });
                  }, 600);
              }
  
  
              //==============Start To Remove whole "UL" and all "tages" in <select> except WORLDWIDE when clicked on WORLDWIDE==========By Rana=======//
  
              if (li.text() == 'WORLDWIDE') {
                  ul.addClass('notShown');
                  for (let i = 0; i < anchors.length; i++) {
                      console.log("this is anchor before:", anchors[i].firstChild.textContent);
                      // console.log("this is anchor before:", anchors[i].parentNode);
  
  
                      if (anchors[i].firstChild.textContent != "WORLDWIDE") {
                          console.log("This is innerhtml", $('#Country').val());
                          // $('#Country').val() = "";
  
                          anchors[i].setAttribute("class", "remove");
                          anchors[i].setAttribute("class", "disappear");
                          // $('#Country').val().dismiss;
                          // anchors[i].firstChild.textContent.setAttribute("class", "notShown");
                          // anchors[i].firstChild.remove();
  
  
                          // anchors[i].firstChild.setAttribute("class", "notShown");
                          // select.find('option:contains(' + anchors[i].firstChild.textContent + ')').prop('selected', false)
                          anchors[i].remove();
                          // anchors[i].addClass("disappear");
  
  
                      }
                      console.log("this is anchor after:", anchors[i].firstChild.textContent);
  
                  }
              }
  
              //==============End To Remove whole UL when clicked on WORLDWIDE==========By Rana=======//
          });
  
          $(document).on('click', '.selectMultiple > div a', function(e) {
              var select = $(this).parent().parent();
              var self = $(this);
              self.removeClass().addClass('remove');
              select.addClass('open');
              submitMove.addClass("sub-move");
              setTimeout(function() {
                  self.addClass('disappear');
                  setTimeout(function() {
                      self.animate({
                          width: 0,
                          height: 0,
                          padding: 0,
                          margin: 0
                      }, 300, function() {
                          var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                          li.slideDown(400, function() {
                              li.addClass('show');
                              setTimeout(function() {
                                  select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                                  if (!select.find('option:selected').length) {
                                      select.children('div').children('span').removeClass('hide');
                                  }
                                  li.removeClass();
                              }, 400);
                          });
                          self.remove();
                      })
                  }, 300);
              }, 100);
          });
  
          $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
              $(this).parent().parent().toggleClass('open');
              submitMove.toggleClass("sub-move");
              console.log("this is submit to move",submitMove);
          });
  
      });
  
  