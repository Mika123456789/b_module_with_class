window.tblpath = (function(){
	this.ajaxPath = '/ajax.php';
});

tblpath.prototype.searchQuestions = function(query, callback){
	var ajaxArr = {
		query  : query,
		page   : location.href,
		action : "search-answers",
		sessid : BX.bitrix_sessid(),
		site_id: BX.message('SITE_ID'),
	};

	$.post(this.ajaxPath, ajaxArr, function(answer){
		 console.log(ajaxArr);
		 console.log(answer);

		if (typeof callback !== 'undefined'){
			//callback(answer);
		}
	}, "json");
};

