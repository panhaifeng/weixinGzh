var charsContent = [
    { name:"pzfh", title:'字符：', content:toArray("∩,∧,-,∨,∪,∏,")},
],
    boardCache = {
        'onFocus': null,
        'inputMode':'ltr', // ltr 从左向右, ttd 从上向下, hth
        'total':0, // 共需输出多少字符
        'rangX':0, // 横向有效输出范围
        'rangY':0  // 竖向有效输出范围
    };
function toArray(str){
    return str.split(",");
}
function charsToArray(str){
    var charData = [];
    var charArr = str.split(",");
    for(j = 0; j < charArr.length; j++) {
        var cc =  charArr[j].split(":");
        charData[cc[0]]=cc[1];
    } 
    return charData;
}
var chars = charsToArray(_chars);
$(function(){
    $('#removeChars').live('click',function(){
        window.location.href="?controller=Jichu_Chanpin&action=ViewChar";
    })

    $('.charsItem').live('click',function(){
        var re = this;
        boardCache.onFocus = re;
    })
    /*暂时不用下面三种模式，只默认一种默认*/
    $('#btnTtD').live('click',function(){
        boardCache.inputMode = 'ttd';
    })
    $('#btnLtR').live('click',function(){
        boardCache.inputMode = 'ltr';
    })
    $('#btnSD').live('click',function(){
        boardCache.inputMode = 'sd';
    })
    /*暂时不用上面三张模式*/

    //ok
    $('#ok').click(function(){
        var che_data = getSelData();
        var chartext = che_data.selData;

        chartext = chartext.replace(/"/g,"");
        chartext = chartext.replace('[',"");
        chartext = chartext.replace(']',"");

        //返回已选择的数据
        var obj = {data:chartext};
        parent.layer.callback(index,obj);
        parent.tb_remove();
    });

    //back
    $('#back').click(function(){
        parent.tb_remove();
    });

});
function getSelData(){
    var data = [];
    var resData = [];
    $('[name="chars[]"]').each(function(){
        if(this.value){
            var currentRow = this.getAttribute('data-row'),
                currentCol = this.getAttribute('data-col');

            data[currentRow+'-'+currentCol] = this.value;
            resData.push(currentRow+'-'+currentCol+':'+this.value);
        }
    });
    // console.log(data);
    // console.log($.toJSON(data));
    // console.log(resData);
    // console.log(JSON.stringify(resData));
    return {'selData':JSON.stringify(resData)};
}

(function initDialog(content, row, col){
    var createTab = function (tab, index) {
        // 创建TabHead
        var headSpan = document.createElement("span");

        headSpan.setAttribute("tabSrc", ci.name);

        headSpan.innerHTML = ci.title;

        // 默认激活第一个tab
        if (index == 1) {
            headSpan.className = "focus";
        }

        $("#tabHeads").append(headSpan.innerHTML);


        // 创建 tabBody中的字符块
        var bodyDiv = document.createElement("div");

            bodyDiv.id = ci.name;

            bodyDiv.style.display = (index == 1) ? "" : "none";

            for (var i = 0, char; char = ci.content[i++];)
            {
                var charSpan = document.createElement("span");

                charSpan.innerHTML = char;
             
                charSpan.setAttribute("onclick", "insertChar(this.innerHTML)"); 

                bodyDiv.append(charSpan);
            }
            $("#tabBodys").append(bodyDiv.innerHTML);
        }
        ,createTr  = function (col, index){
            var tmpTr = document.createElement("tr");

            //下三角注释
            if(index==2){
                var tmpTrExt = document.createElement("tr");
                var tmpTdExt = document.createElement("span");
                var tmpTexT = document.createTextNode("下三角");


                tmpTdExt.setAttribute("style",'position:absolute;');

                tmpTrExt.setAttribute("colspan", 42);
                tmpTrExt.setAttribute("height", 20);
                tmpTrExt.setAttribute("width", 140);

                tmpTdExt.append(tmpTexT);
                tmpTrExt.append(tmpTdExt);
                $("#tableBoard").append(tmpTrExt);
            }

            for (var j = 0; j<col; j++)
            {
                
                var tmpTd = document.createElement("td"),
                    tmpInput = document.createElement("input");

                if(chars.hasOwnProperty(index+'-'+j)){  //chars[index+'-'+j] 
                    tmpInput.value = chars[index+'-'+j];
                }

                tmpInput.id     = "pos" + j +"-"+index;
                tmpInput.name   = "chars[]";
                tmpInput.className = "charsItem";

                tmpInput.setAttribute("maxlength", 1);
                tmpInput.setAttribute("data-row", index);
                tmpInput.setAttribute("data-col", j);
                    
                // tmpInput.setAttribute("focus", boardCache.onFocus = this); 

                // tmpInput.addEventListener("focus",boardCache.onFocus = tmpInput,false);
              

                tmpTd.append(tmpInput);
                tmpTr.append(tmpTd);
            }
            $("#tableBoard").append(tmpTr);
        }
        ,createHead  = function (col, index){
            var tmpTr = document.createElement("tr");

            for (var j = 0; j<col; j++)
            {
                var tmpTd = document.createElement("td"),
                    tmpInput = document.createElement("input");
                var jj = j+1;
                tmpInput.value = jj;

                tmpInput.name   = "charsNum[]";
                tmpInput.className = "charsNum";

                tmpInput.setAttribute("disabled", true);
                    
                // tmpInput.setAttribute("focus", boardCache.onFocus = this); 

                // tmpInput.addEventListener("focus",boardCache.onFocus = tmpInput,false);

                tmpTd.append(tmpInput);
                tmpTr.append(tmpTd);
            }
            $("#selfHead").append(tmpTr);
        };

    // 创建 Tab
    for (var i = 0, ci; ci = content[i++];)
    {
        createTab(ci, i);
    }

    // 创建 页眉
    createHead(col, i);


    // 初始化 工艺针型界面
    for (var i = 0; i < row; i++)
    {
        createTr(col, i);
    }

    // 默认选中第一格
    document.getElementById('pos0-0').focus();
   
    // 载入选中区的内容,重新调整
    // range = editor.selection.getRange();
    //
    // selfCharsNode = editor.selection.getRange().getClosedNode();
    // debugger;

})(charsContent, 6, 42);

var insertChar = function(char) {
   // 焦点处于 charsItem Input 控件上时，才进行处理
    if(!boardCache.onFocus)
    {
        boardCache.onFocus =  document.getElementById("pos0-0");
    }
    boardCache.onFocus.value = char;

    // 转移焦点到另一个input框中
    refocusInput(boardCache.onFocus);
}

var refocusInput = function(currentInput){
    var mode = boardCache.inputMode,
        currentRow = currentInput.getAttribute('data-row'),
        currentCol = currentInput.getAttribute('data-col'),
        targetId = '',
        rangRow = parseInt($('row').value)?parseInt($('row').value):-1,
        rangCol = parseInt($('col').value)?parseInt($('col').value):-1,
        targetRow = currentRow,
        targetCol = currentCol;

    switch (mode){
        case "ltr":

            // 向右未出界
            if(rangCol * (rangCol-1-currentCol)>0)
            {
                // 光标向右移动一格
                targetCol++;

            }else{
                // 向右出界，向下补位(从左端补起)
                // 向下未出界,则光标顺利下移；否则，不处理
                if(rangRow*(rangRow-currentRow-1)>0){
                    targetRow++;
                    targetCol=0;
                }
            }

            break;
        case "ttd":
            // 向下未出界
            if(rangRow*(rangRow-currentRow-1)>0)
            {
                // 光标向下移动一格
                targetRow++;

            }else{
                // 向下出界，向右补位(从下一列首行补起)
                // 向右未出界,则光标顺利右移；否则，不处理
                if(rangCol * (rangCol-1-currentCol)>0){
                    targetCol++;
                    targetRow=0;
                }
            }
            break;
        // contain hth 手动模式
        default:
            break;
    }

    targetId =  targetCol+"-"+targetRow;
    // console.log(targetId+" rang:r "+rangRow+" | c "+rangCol);

    document.getElementById("pos"+targetId).focus();
    boardCache.onFocus = document.getElementById("pos"+targetId);
   
}


