var numPages=4;
        function show(pageShown) {
            for (i=1; i<numPages+1; i++) {
                if (i==pageShown) {
                    document.getElementById(i).style.display='block';
                    console.log("Showing page "+i);
                }
                else {
                    document.getElementById(i).style.display='none';
                    console.log("Hidding page "+i);
                }
            }
        }

        function myFunction() {
            // Declare variables
            var input, filter, ul, li, a, i;
            input = document.getElementById('myInput');
            filter = input.value.toUpperCase();
            ul = document.getElementById("myUL");
            li = ul.getElementsByTagName('li');

            // Loop through all list items, and hide those who don't match the search query
            for (i = 0; i < li.length; i++) {
                a = li[i].getElementsByTagName("a")[0];
                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }

        function redir(url) {
            url = encodeURI(url);
            url = url.replace(/#/g, '&');
            url = url.replace(/atschool/, 'sendreport');
            window.location.href = url;
        }