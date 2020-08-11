jQuery(function($){
var htxt=`<!-- Modal -->
 <div class="modal fade" id="getCodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-lg">
      <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="myModalLabel"> API CODE </h4>
       </div>
       <div class="modal-body" id="getCode" style="overflow-x: scroll;">
          //ajax success content here.
       </div>
    </div>
   </div>
 </div>`;
	// $('body').append(htxt);
$('body > header > nav > div > div.navbar-header').append('<a href="javascript:void(0)" onclick=\'$("#filecontainer").modal("show");$("#getfilecontainer").show();return false\' class="btn btn-default">add file <i class=""></i></a>');	
	
$.ajax({
    type: "POST",
    url: "/",
    data: {
        'apiName': 'apiName',
        'api': 'api',
        'hotel': 'hotel',
        'payment':'payment',
        'template': 'template'
    },
    success: function(resp){
		// $("#getCode").html(resp);
		// $("#getCodeModal").modal('show');
	}
});	
	
	
	
  });
