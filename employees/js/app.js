(function($) {

	"use strict";

	var fullHeight = function() {

		$('.js-fullheight').css('height', $(window).height());
		$(window).resize(function(){
			$('.js-fullheight').css('height', $(window).height());
		});

	};
	fullHeight();

	$('#sidebarCollapse').on('click', function () {
      $('#sidebar').toggleClass('active');
  });

})(jQuery);

document.addEventListener('click' , (e) => {

  let {target} = e;

	if (target && target.classList.contains('fa-search')) {
		getReservation();
	}
});

function getReservation(){
	let id = document.querySelector('#idReservation');
	let idTbody = document.querySelector('#idTbody').children;
		for (var i = 0; i < idTbody.length; i++) {
			let idTr	= idTbody[i].children;
			if (idTr[0].innerHTML === id.value) {
				let idElement = idTr[0].innerHTML;
				let el = document.getElementById(idElement).parentElement;
 				el.tabIndex = "-1";
 				el.focus();
				el.scrollIntoView(idElement);

			}

		}
}
function scrollIntoView(eleID) {
   var e = document.getElementById(eleID);
   if (!!e && e.scrollIntoView) {
       e.scrollIntoView();

   }
}
