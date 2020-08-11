console.log('..load main.js');
(function () {
    'use strict';

    BX.namespace('BX.Lc.Main');
    

        var is_debug=true,
            // is_debug=false,
			is_preview_and_predemo=true,
            chtmtable='#mtable',
            chejmtable=$(chtmtable),
            swind_mtable='#wind_mtable',
            owind_mtable=$(swind_mtable),
            ssubwindmtable='#wind_mtableCode',
            osubwindmtable=$('#wind_mtableCode'),
            demores={
                'columns':[
					{title:"#", formatter:"rownum", align:"center", width:40},
					{title:"Name",   field:"name"},
					{title:"Card ID",   field:"card"},
					{title:"Access", field:"access", sorter:"number"},
					{title:"Del",  width:60 , formatter:"buttonCross", align:"center"},
					{title:"Edit", width:60 , formatter:"buttonTick", align:"center" },
					],
                'data':[
                    {
                    "id": 1,
                    "name": "Gustav Haas",
                    "card": "1254874",
                    "access": "801"
                },
                {
                    "id": 2,
                    "name": "John Strauss",
                    "card": "45ea87a",
                    "access": "401"
                },
                {
                    "id": 3,
                    "name": "Peter Philips",
                    "card": "188dabf",
                    "access": "301"
                },
                {
                    "id": 4,
                    "name": "Dan Svensen",
                    "card": "eddaf34",
                    "access": "101"
                },
            ]
                },
            // tableMain=new Tabulator(chtmtable),
            ik, n;    
    
            // window.wsrt.exec = (function(){
                // this.ajaxPath = '/local/modules/wsrt.local/ajax.php'; 
            // });
                window.wsrt={
                    'ajaxPath':'/local/modules/wsrt.local/ajax.php'
                };
            
                 /*window.Lc.searchOffers = function(query, callback){
                    var ajaxArr = {
                        query  : typeof query!='undefined'?query:'empty_query',
                        page   : location.href,
                        action : "search-Offers",
                        sessid : BX.bitrix_sessid(),
                        site_id: BX.message('SITE_ID'),
                    };

                    $.post(window.Lc.wsrt.ajaxPath, ajaxArr, function(answer){
                        console.log('ajaxArr',ajaxArr);
                        console.log('answer',answer);

                        if (typeof callback !== 'undefined'){
                            callback(answer);
                        }
                    }, "json");
                };*/

                

        BX.Lc.Main = {
            initCollapsedText: function () {
                console.log('..init1',ik.hideObj($('body')));
            },
            searchOffers: function(query, callback){
                    var ajaxArr = {
                        query  : typeof query!='undefined'?query:'empty_query',
                        page   : location.href,
                        action : "whatis",
                        sessid : BX.bitrix_sessid(),
                        site_id: BX.message('SITE_ID'),
                    };

                    $.post(window.wsrt.ajaxPath, ajaxArr, function(answer){
                        console.log('ajaxArr',ajaxArr);
                        console.log('answer',answer);

                        if (typeof callback !== 'undefined'){
                            callback(answer);
                        }
                    }, "json");
                },
            loadGrid: function (dmtable={},hmtable={},ohtml=chtmtable) {
            /*
                BX.Lc.Main.loadGrid({},{})
                BX.Lc.Main.loadGrid(window.res['data'],window.res['column'])
                BX.Lc.Main.loadGrid(window.res['data'],window.res['columns'])
                $ret=new \MPrep;
                $ret=$ret->viewDoc(54401);
                function(query, callback){
                    var ajaxArr = {
                        query  : typeof query!='undefined'?query:'empty_query',
                        page   : location.href,
                        action : "search-Offers",
                        sessid : BX.bitrix_sessid(),
                        site_id: BX.message('SITE_ID'),
                    };

                    $.post(window.Lc.wsrt.ajaxPath, ajaxArr, function(answer){
                        console.log('ajaxArr',ajaxArr);
                        console.log('answer',answer);

                        if (typeof callback !== 'undefined'){
                            callback(answer);
                        }
                    }, "json");
                };                
                
                
                
            */

                
                if (typeof Tabulator!='function') {
                        ik.addJs('//cdnjs.cloudflare.com/ajax/libs/tabulator/4.7.1/js/tabulator.min.js');
                        ik.addJs('//cdnjs.cloudflare.com/ajax/libs/tabulator/4.7.1/js/tabulator_core.min.js');
                } else {
                    
                }
                var ohtml_=ohtml.split("#").length>1?ohtml.split("#")[1]:ohtml;
                if (typeof $(ohtml).html()==='undefined') {
                    console.log('..not find element chtmtable,append at header: #',ohtml);
                   
                    if(ik.addHtml('<div id="'+ohtml_+'" class="tabulator" role="grid" tabulator-layout="fitData"><div class="tabulator-header" style="padding-right: 0px;"><div class="tabulator-headers" style="margin-left: 0px;"></div><div class="tabulator-frozen-rows-holder"></div></div><div class="tabulator-tableHolder" tabindex="0" style="height: 20px;"><div class="tabulator-table" style="min-width: 0px; min-height: 1px; visibility: hidden;"></div></div></div>','header')){
                        // exec code if appended; //
                        // return;
                    }
                }
                
                if (Object.keys(dmtable).length<1&&Object.keys(hmtable).length<1) {
                    // console.log('..incoming is empty:',hmtable,dmtable);return false;
                    n.maketable(demores['data'],demores['columns'],ohtml);
                }else{
                    n.maketable(dmtable,hmtable,ohtml)
                }
            
                      
                
            },
           loadGridModal: function (dmtable={},hmtable={},ohtml=chtmtable) {
                if (typeof Tabulator!='function') {
                    ik.addJs('//cdnjs.cloudflare.com/ajax/libs/tabulator/4.7.1/js/tabulator.min.js');
                    ik.addJs('//cdnjs.cloudflare.com/ajax/libs/tabulator/4.7.1/js/tabulator_core.min.js');
                }
                
                if (typeof $('#wind_mtable').html()==='undefined') {
                    console.log('..not find element wind_mtable,append at header');
                        jQuery(function($){
                            var httwind_mtable=`<!-- Modal -->
                             <div class="modal fade" id="wind_mtable" tabindex="-1" role="dialog" aria-labelledby="wind_mtableLabel" aria-hidden="true">
                               <div class="modal-dialog modal-lg">
                                  <div class="modal-content">
                                   <div class="modal-header">
                                     <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                     <h4 class="modal-title" id="wind_mtableLabel">  </h4>
                                   </div>
                                   <div class="modal-body" id="wind_mtableCode" style="overflow-x: scroll;">
                                      <div id="windmtable" class="tabulator" role="grid" tabulator-layout="fitData"><div class="tabulator-header" style="padding-right: 0px;"><div class="tabulator-headers" style="margin-left: 0px;"></div><div class="tabulator-frozen-rows-holder"></div></div><div class="tabulator-tableHolder" tabindex="0" style="height: 20px;"><div class="tabulator-table" style="min-width: 0px; min-height: 1px; visibility: hidden;"></div></div></div>
                                   </div>
                                </div>
                               </div>
                             </div>`
                                
                            if(ik.addHtml(httwind_mtable)){n.runmwindow()}; //$('body').append(httwind_mtable);
                                });
                       
                }else{
                    n.runmwindow();
                }
        
                
                if (Object.keys(dmtable).length<1&&Object.keys(hmtable).length<1) {
                    // console.log('..incoming is empty:',hmtable,dmtable);return false;
                    // n.maketable(demores['data'],demores['columns'],'#windmtable');
                    try {
                        setTimeout(function(){ 
                            n.maketable(demores['data'],demores['columns'],'#windmtable');
                            },1500) 
                    } catch(e) {
                        console.log(e);
                    }
                }else{
                    // n.maketable(dmtable,hmtable,'#windmtable');
                    // document.getElementById('test').innerHTML += str
                    try {
                        setTimeout(function(){ 
                            n.maketable(dmtable,hmtable,'#windmtable');
                            },1500) 
                    } catch(e) {
                        console.log(e);
                    }
                    
                }
                
              /*
                $("#wind_mtable").modal("show");
                BX.Lc.Main.loadGridModal({},{})
                */

                

                
                

            },loadData: function(query,action, callback){
                /*viewDoc" and isset($_POST['num
                loadData('num=54401','viewDoc')
                retview['data']=BX.Lc.Main.loadData(num,'viewDoc');
                */
                var ret;
                    var ajaxArr = {
                        query  : typeof query!='undefined'?query:'empty_query',
                        page   : location.href,
                        action : typeof action!='undefined'?action:'search-Offers',
                        sessid : BX.bitrix_sessid(),
                        site_id: BX.message('SITE_ID'),
                    };
                    // var wait = BX.showWait();
                    $.post(window.wsrt.ajaxPath, ajaxArr, function(answer){
                        // console.log('ajaxArr',ajaxArr);
                        if (typeof callback !== 'undefined'){
                        }
                        if (typeof answer==='object') {
                            return answer;
                        } else {
                            return {};
                        }
                    }, "json");
                    // BX.closeWait(null, wait);
            }, addFile_window(b_sessid,param='',Id=0){
                /*
                
                BX.Lc.Main.addFile_window()
                */
                typeof b_sessid!='undefined'?b_sessid:'';
                $("#filecontainer").modal("show");
                $("#getfilecontainer").empty();
                var ret={};
                var aurl='/zayavki-na-materialy/add_file.php'; 
                var request = $.ajax({
                    url: aurl+'?ajax=yes&sessid='+b_sessid,// + $.param(aq),
                    method: 'GET',
                    sessid : b_sessid,  //BX.bitrix_sessid(),
                    data: ret//JSON.stringify(ret)//
                });
                 
                request.done(function (response) {
                    $('header > form').empty();
                    // $('header').append(response)$("#getfilecontainer").find('.form-group > div').empty().append('<input type=\"submit\" class=\"btn btn-primary\" name=\"iblock_apply\" value=\"Применить\">')
                    // response=$(response).
                    $('header').append(response);
                    $("#getfilecontainer").css('height', '379px').html(response).find('.form-group > div').empty().find('#bx_incl_area_3_1_1 > font').empty().show(); 
                    // console.log($('header > form').serializeArray());
                    
                    $("#getfilecontainer").find('.form-group > div').empty().append('<input type=\"submit\" class=\"btn btn-primary\" name=\"iblock_apply\" value=\"Отправить\" onclick=\"\">');
                    
                    
                });   

                
                
            },addFile_toBD(b_sessid=BX.bitrix_sessid()){
                typeof b_sessid!='undefined'?b_sessid:'';
                var fdata=$("#getfilecontainer > form").serializeArray();
                // var fdata=new FormData($("#getfilecontainer > form"));
                // console.log(fdata);
                var ret={};
                // var aurl='/zayavki-na-materialy/add_file.php'; 
                var aurl='/about/upload.php';
                var request = $.ajax({
                    // url: aurl+'?ajax=yes&edit=Y&CODE=54448',// + $.param(aq),iblock_submit
                    url: aurl+'?ajax=yes&edit=Y&CODE=54459&iblock_submit=Отправить',
                    method: 'POST',
                    sessid : b_sessid,  //BX.bitrix_sessid(),
                    data: fdata//JSON.stringify(ret)//
                });
                 
                request.done(function (response) {
                    $('header > form').empty();
                    // $('header').append(response)$("#getfilecontainer").find('.form-group > div').empty().append('<input type=\"submit\" class=\"btn btn-primary\" name=\"iblock_apply\" value=\"Применить\">')
                    // response=$(response).
                    $('header').append(response);
                    $("#getfilecontainer").css('height', '379px').html(response).find('.form-group > div').empty().find('#bx_incl_area_3_1_1 > font').empty().show(); 
                    // console.log($('header > form').serializeArray());
                    
                    $("#getfilecontainer").find('.form-group > div').empty().append('<input type=\"submit\" class=\"btn btn-primary\" name=\"iblock_apply\" value=\"Отправить\" onclick=\"\">');
                    
                    
                });  
                
                
                
            }
        };
    
        ik = {
            _def: function(s=''){
                !s.length?s='qwerty':s;
                _s=preset[s];
                s=typeof _s !='undefined'?_s:'__'+s;
                return s;
            },
            _enf: function(s=''){
                !s.length?s='qwerty':s;
                _s=setpre[s];
                s=typeof _s !='undefined'?_s:'__'+s;
                return s;
            },
			itObj: function(thiz){
				if (typeof $(thiz)!='undefined')
					{
					$("body,html").animate({scrollTop: $(thiz).offset().top},800);
					iw=5;
					while(iw--){  $(thiz).fadeIn().fadeOut().fadeIn();  }
						
					}
            },
            showObj: function(thiz){
				if (typeof $(thiz)!='undefined')
					{
						$(thiz).show(1500).animate({"opacity":"1"});
						$(thiz).css({'display':'unset'});
					}
            },
			hideObj: function(thiz){
					if (typeof $(thiz)!='undefined')
					{
						$(thiz).show(1000).animate({"opacity":"0"});
						$(thiz).css({'display':'none'});						
					}

            },
            addJs: function(pathks){
                var jq = document.createElement('script'); jq.type = 'text/javascript';
                        jq.src = pathks;
                        document.getElementsByTagName('head')[0].appendChild(jq);
            },
            addHtml:function(shtml='',splace='body'){
                  var odiv = document.createElement("p");
                  odiv.innerHTML = shtml;
                  document.getElementsByTagName(splace)[0].appendChild(odiv);
                return 1;
            }
        };

        n = {
            error: $(".error"),
            pprint: function() {
                console.log({});
            },
            runmwindow: function(){
                $("#wind_mtable").modal("show");
            },
            maketable: function(d,hd,fchtmtable=chtmtable) {
                         window.mtable = new Tabulator(fchtmtable, {
                        pagination: "local",
                        paginationSize: 15,
                        resizableColumns: false,
                        paginationSizeSelector: [50, 100],
                        // height://"751px",
                        headerSort:true,
                        layout:"fitColumns",
                        data:d,//window.exceljson, //load data into table
                             
                        dataEdited:function(data){
                            is_debug&&console.log('dataEdited',data);
                        }, 
                        cellEdited:function(cell){
                            // if(!cell.getData().IsEnable){cell.getRow().getElement().style.backgroundColor = "#A6A6DF";}
                        },
                        rowFormatter:function(row){
                            var data = row.getData(); //get data object for row

                            if(!data.IsEnable){
                                // row.getElement().style.backgroundColor = "#A6A6DF";     
                            }
                        },
                        columns:hd,
                    });

            }};
        
    
})();
