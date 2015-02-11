jQuery(function() {
	jQuery("#windowOpen").bind(
			"click",
			function() {
			  if (jQuery("#window").css("display") == "none") {
				  jQuery(this).TransferTo(
						{
						  to: "window",
						  className: "transferer2",
						  duration: 400,
						  complete: function() {
							  jQuery("#window").show();
						  }
						}
					);
			  }
			  this.blur();
			  return false;
			}
		);

	jQuery("#windowClose").bind(
			"click",
			function() {
				jQuery("#window").TransferTo(
					{
					  to: "windowOpen",
					  className: "transferer2",
					  duration: 400
					}
				).hide();
			}
		);

	jQuery("#windowMin").bind(
			"click",
			function() {
			  jQuery("#windowContent").SlideToggleUp(300);
			  jQuery("#windowBottom, #windowBottomContent").animate({ height: 10 }, 300);
			  jQuery("#window").animate({ height: 40 }, 300).get(0).isMinimized = true;
			  jQuery(this).hide();
			  jQuery("#windowResize").hide();
			  jQuery("#windowMax").show();
			}
		);

  jQuery("#windowMax").bind(
			"click",
			function() {
			  var windowSize = jQuery.iUtil.getSize(document.getElementById("windowContent"));
			  jQuery("#windowContent").SlideToggleUp(300);
			  jQuery("#windowBottom, #windowBottomContent").animate({ height: windowSize.hb + 13 }, 300);
			  jQuery("#window").animate({ height: windowSize.hb + 43 }, 300).get(0).isMinimized = false;
			  jQuery(this).hide();
			  jQuery("#windowMin, #windowResize").show();
			}
		);

  jQuery("#window").Resizable(
			{
			  minWidth: 200,
			  minHeight: 60,
			  maxWidth: 700,
			  maxHeight: 400,
			  dragHandle: "#windowTop",
			  handlers: {
			    se: "#windowResize"
			  },
			  onResize: function(size, position) {
			    jQuery("#windowBottom, #windowBottomContent").css("height", size.height - 33 + "px");
			    var windowContentEl = jQuery("#windowContent").css("width", size.width - 25 + "px");
			    if (!document.getElementById("window").isMinimized) {
			      windowContentEl.css("height", size.height - 48 + "px");
			    }
			  }
			}
		);
});
