$(document).ready(function ()
{
  $("#cb_select_all").bind("click",function(e){
    $("table#main input.checkbox").attr("checked",$(this).attr("checked"));    
  })

  // Обработка раскрывающегося списка выбора группы на странице управления
  $("#selectsetlabel").bind("click",function(e){
    
    // Если в списке
    if($(this).val() == "new")
    {
      $("input#newlabel").show();
    }
    else
    {
      $("input#newlabel").hide();
    }
  });
  
  $("input#filter_label_submit").hide();

  // Обработка раскрывающегося списка выбора группы на странице просмотра
    $("#filter_label_form #label").bind("change",function(e){
      $("#filter_label_form").submit();
    });
    
    
    
  // сортировщик
  
  $.tablesorter.addParser({ 
      id: 'ezhamon1', 
      is: function(s) { 
          return false; 
      }, 
      format: function(s) {          
          s = s.toLowerCase().replace(/<span class='gray'>.*?<\/span>/,'').
          s = s.replace(/<[^>]*>/ig,''); 
          s = s.replace(/[^0-9]/ig,'');
          return s;
      }, 
      type: 'numeric' 
  }); 
  
  $("#main").tablesorter({ 
        headers: { 
            0: { sorter: 'digit' }, 
            2: { sorter: 'ezhamon1' }, 
            3: { sorter: 'ezhamon1' }, 
            4: { sorter: 'ezhamon1' }, 
            5: { sorter: 'ezhamon1' }, 
            6: { sorter: 'ezhamon1' }, 
            7: { sorter: 'ezhamon1' }, 
            8: { sorter: 'ezhamon1' }, 
            9: { sorter: 'ezhamon1' }, 
            10: { sorter: 'ezhamon1' }, 
            11: { sorter: 'ezhamon1' } 
        } 
    }); 
});


function formatDate(formatDate, formatString)
{
      var yyyy = formatDate.getFullYear();
      var yy = yyyy.toString().substring(2);
      var m = formatDate.getMonth() + 1;
      var mm = m < 10 ? "0" + m : m;
      var d = formatDate.getDate();
     var dd = d < 10 ? "0" + d : d;

      var h = formatDate.getHours();
    var hh = h < 10 ? "0" + h : h;
    var n = formatDate.getMinutes();
    var nn = n < 10 ? "0" + n : n;
    var s = formatDate.getSeconds();
    var ss = s < 10 ? "0" + s : s;

    formatString = formatString.replace(/yyyy/i, yyyy);
    formatString = formatString.replace(/yy/i, yy);
    formatString = formatString.replace(/mm/i, mm);
    formatString = formatString.replace(/m/i, m);
    formatString = formatString.replace(/dd/i, dd);
    formatString = formatString.replace(/d/i, d);
    formatString = formatString.replace(/hh/i, hh);
    formatString = formatString.replace(/h/i, h);
    formatString = formatString.replace(/nn/i, nn);
    formatString = formatString.replace(/n/i, n);
    formatString = formatString.replace(/ss/i, ss);
    formatString = formatString.replace(/s/i, s);

    return formatString;  
}

Date.prototype.format = function(format)
{
  return formatDate(this, format);
}