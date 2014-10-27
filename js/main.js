function getBaseURL() {
    var url = location.href;
    var baseURL = url.substring(0, url.indexOf('/', 14));
    if (baseURL.indexOf('http://localhost') != -1) {
        var url = location.href;  
        var pathname = location.pathname; 
        var index1 = url.indexOf(pathname);
        var index2 = url.indexOf("/", index1 + 1);
        var baseLocalUrl = url.substr(0, index2);

        return baseLocalUrl + "/";
    }
    else {
        return baseURL + "/";
    }
}
   
function page(page)
{
   if (page != '')
   {
      location.href = page.id + '.php';
   }
   else
   {
      location.href = getBaseURL();
   }   
}

var highlightDetailColor = null;
var highlightDetailBgColor = null;

function highlightItem(e)
{
   highlightDetailColor = e.style.color;
   highlightDetailBgColor = e.style.backgroundColor;
   e.style.color = '#000000';       
   e.style.backgroundColor = '#ff8c00';
}

function dimItem(e)
{
   e.style.color = highlightDetailColor;
   e.style.backgroundColor = highlightDetailBgColor;
}

function toggleItemInfo(itemInfo)
{
   var d = document.getElementById(itemInfo).style.display;
   if (d != 'block')
   {
      document.getElementById(itemInfo).style.display = 'block';
   }
   else
   {
      document.getElementById(itemInfo).style.display = 'none';
   }
}

function returnToTop()
{
   window.scrollTo(0,0)
}
