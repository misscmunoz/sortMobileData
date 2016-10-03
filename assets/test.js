/**
 * Created by Missy on 02/10/2016.
 */
var test = test || {};
var doc = document;

/**
 * Show mobile information
 * @param elm
 * @param id
 */
test.toggleMobileInfo = function(elm,id){
    var parentNode = elm.parentElement,
        info =  parentNode.childNodes,
        close = doc.createElement('a');

        close.href =  'onclick=test.closeInfo(this)';
        close.innerHTML = 'test';

    if (info.length === 1)
    {
        //Create mobile info div
        var mobileInfo  = doc.createElement("table");
            mobileInfo.id = 'mobileInfo';

        parentNode.appendChild(mobileInfo);

        $.post('ajaxHandler', { action: "findRowJS", id: id },
            function(data){
                test.addMobileInfo(mobileInfo,data);
            },'JSON');

    }else{
        info[1].remove();
    }


};

/**
 * Put mobile information into p element
 * @param parentNode
 * @param data
 */

test.addMobileInfo = function(parentNode, data){
    var item,
        itemName;

    //Loop through each of the data
    for (item in data){

        //Check if the name has an underscore
        itemName = test.removePartOfString(item,"_");

        //Create the element and format values
         var tr = doc.createElement("tr"),
             tdKey = doc.createElement("td"),
             tdValue = doc.createElement("td"),
             key = doc.createTextNode(test.capitaliseFirstLetter(itemName)),
             value =  doc.createTextNode(data[item]);

        //Put the value in table data
        tdKey.appendChild(key);
        tdValue.appendChild(value);

        //Add the value to the table row
        tr.appendChild(tdKey);
        tr.appendChild(tdValue);

        //Add the table to the parentNode
        parentNode.appendChild(tr);
    }
};

/**
 * Capitalise first letter
 * @param string
 * @returns {string}
 */
test.capitaliseFirstLetter = function (string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
};

/**
 * Removed unnecessary part of a string
 * @param item
 * @param $str
 * @returns {Blob|ArrayBuffer|Array.<T>|string}
 */
test.removePartOfString = function(item,$str){
    return item.slice(item.indexOf($str) + 1);
};


window.onload = function(){
    $("#loader").fadeOut("slow");

    var sort = doc.getElementById("sort"),
        loader =  doc.getElementById("loader");

    sort.addEventListener("change", function() {

        $.ajax({
            url: 'ajaxHandler.php',
            data: {
                action: 'getSortValues',
                id: sort.selectedIndex
            },
            beforeSend: function(){
                loader.style.display = 'block';
            },
            complete: function(result) {

                $.post('ajaxHandler.php', { action: "output", data: result.responseText },
                    function(data){
                        //Remove loader
                        $("#loader").fadeOut("slow");

                        //Remove existing table rows
                        $('tr').remove();

                        //Append our data
                        $('#resultTable').append(data);
                    });
            },
            type: 'POST'
        });

    });
};

