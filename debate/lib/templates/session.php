<div class="modal fade" id="loggedout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Page Session Expired</h5>
	  </div>
	  <div class="modal-body">
		<p>Your login session has expired. Please refresh the page.</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="location.reload()">Refresh</button>
	  </div>
	</div>
  </div>
</div>		


<script>
/**
Thank you to the author of JQuery Idle for making this!
*/
!function(n){"use strict";n.fn.idle=function(e){var t,i,o={idle:6e4,events:"mousemove keydown mousedown touchstart",onIdle:function(){},onActive:function(){},onHide:function(){},onShow:function(){},keepTracking:!0,startAtIdle:!1,recurIdleCall:!1},c=e.startAtIdle||!1,d=!e.startAtIdle||!0,l=n.extend({},o,e),u=null;return n(this).on("idle:stop",{},function(){n(this).off(l.events),l.keepTracking=!1,t(u,l)}),t=function(n,e){return c&&(c=!1,e.onActive.call()),clearTimeout(n),e.keepTracking?i(e):void 0},i=function(n){var e,t=n.recurIdleCall?setInterval:setTimeout;return e=t(function(){c=!0,n.onIdle.call()},n.idle)},this.each(function(){u=i(l),n(this).on(l.events,function(){u=t(u,l)}),(l.onShow||l.onHide)&&n(document).on("visibilitychange webkitvisibilitychange mozvisibilitychange msvisibilitychange",function(){document.hidden||document.webkitHidden||document.mozHidden||document.msHidden?d&&(d=!1,l.onHide.call()):d||(d=!0,l.onShow.call())})})}}(jQuery);

$(document).idle({
  onIdle: function(){
   $('#loggedout').modal({backdrop: 'static', keyboard: false});
  },
  idle: 1440000
})
</script>