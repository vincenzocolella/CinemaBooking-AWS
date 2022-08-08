var dir = "/"; /*opt/lampp/htdocs/registration/*/
var shell_history = [];
var shell_history_idx = -1;

var commandArr = ["ls", 
            "ls -l", 
            "help", 
            "date", 
            "weather ", 
            "pwd", 
            "connect ",
            "hello ", 
            "cd ", 
            "ping ", 
            "cat ",
            "touch ",
            "mkdir ",
            "rm ",
            "rm -R",
            "print db",
            "delete user"
]; 
    

function httpGet(url){
    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", url, false);
    xmlHttp.send(null);
    return xmlHttp.responseText;
}

function processCmd(cmd) {
    var args = cmd.split(' ').filter(function(i) {
        return i
    })
    console.log(args);

    if (args[0] == "help")
        return `<pre class="leet_text">
I Comandi Disponibili Sono:
  help\t\t\t\tmostra questa pagina di aiuto
  date\t\t\t\tmostra la data odierna e l'ora corrente
  weather + city\t\t\tmostra il meteo nella città
  pwd\t\t\t\tprint current dir
  connect\t\t\t\ti nostri social
  hello + name\t\t\tti saluta
  ls || ls -l\t\t\tstampa la directory corrente               
  cd\t\t\t\tcambia directory
  ping + sitename\t\t\tping
  cat\t\t\t\tstampa il contenuto di un file
  touch\t\t\t\tcrea un file vuoto
  mkdir\t\t\t\tcrea una directory
  rm || rm -R\t\t\trimuove file o directory
  print db\t\t\tstampa gli utenti registrati al sito
  delete user + name\t\telimina un utente registrato nel sito
</pre>`;


    else if (args[0] == "pwd") {
        return '<pre class="leet_text" >' + dir + '</pre>';
    } else if (args[0] == "hello") {
        if (args[1] != undefined)
            return '<pre class="leet_text" >' + "Ciao " + args[1] + '</pre>';
        else return '<pre class="leet_text" >' + "Dimmi il tuo nome " + '</pre>';
    } else if (args[0] == "whoami") {
        return `<img class='propic' src='http://www.giornalepop.it/wp-content/uploads/2017/06/GoEIf12-1100x400.jpg'><pre class="leet_text" ></pre>`;
    } else if (args[0] == "connect") {
        return `<div class="connect_div">
    &emsp;&emsp;<a href="https://www.facebook.com/valerio.montagliani1" target = "_blank" class="social_button">
        <img src="img/fb.png" style="width: 50px; height: 50px;">
    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="AggiungiIlNostroGithub" class="social_button" target = "_blank">
        <img src="img/git.png" style="width: 50px; height: 50px;">
    </a>&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="https://twitter.com/lucatomei1995" class="social_button" target = "_blank">
        <img src="img/tw.png" style="width: 50px; height: 50px;">
    </a>
</div>`;
    }
    else if(args[0] == "weather"){
        if(args[1] != null){    // deve essere di lunghezza 2 al massimo
            var city = args[1];
            $.ajax({
                url: 'http://api.openweathermap.org/data/2.5/weather?q=' + city + "&units=metric" + "&APPID=c49f2a5b07ce03250befb407c4410be3&lang=it",
                type: "GET",
                dataType: "json",
                success: function(data){
                    var html = "&thinsp;&thinsp;&thinsp;<a>"+data.name+"</a>";
                    data.weather.forEach(function(city) {
                        html += "<img src='http://openweathermap.org/img/w/"+city.icon+".png'>"+city.description;
                    });
                    $("#show").html(html).insertBefore("#input_div");
                }
            });
            var output = `<pre class="leet_text" id = \"show\" > </pre>`;
            return output;
        }else return '<pre class="leet_text" >' + "Non hai inserito la città" + '</pre>';
    }else if(args[0] == "date"){
       var data = new Date().toLocaleString();
       return '<pre class="leet_text" >' + data + '</pre>';
    }
    else if(args[0] == "ls") {
        if(args[1] == "-l"){
            return '<pre class="leet_text" >' + httpGet('terminale.php?ls-l_var=' + dir) + '</pre>';
        }
        return '<pre class="leet_text" >' + httpGet('terminale.php?ls_var=' + dir) + '</pre>';
    }
    
    else if(args[0] == "cd") {
        if(args.length < 2){
            return '<pre class="leet_text" >cd: usage: cd &lt;directory&gt;</pre>';
        }
        var target = args[1];
        if(target[target.length -1] != "/") target += "/";  // se l'ultima parola è != da '/' --> aggungi '/'
        dir += args[1] + "/";
        if(target[0] == "/"){
            dir = args[1] + "/";
        }
        return '<pre class="leet_text" >' + httpGet('terminale.php?cd_var=' + dir) + '</pre>';
        
    }
    else if(args[0] == "ping"){
        var sitoDaPingare = args[1];
        return '<pre class="leet_text" >' + httpGet('terminale.php?ping_var=' + sitoDaPingare) + '</pre>';
    }
    else if(args[0] == "cat"){
        if(dir[dir.length -1] != "/") dir += "/";
        return '<pre class="leet_text" >' + httpGet('terminale.php?cat_var=' + dir+ args[1]) + '</pre>';
    }else if(args[0] == "touch"){
    	var fileToCreate = args[1];
    	return '<pre class="leet_text" >' + httpGet('terminale.php?touch_var=' + dir+ fileToCreate) + '</pre>';
    }else if(args[0] == "mkdir"){
    	var folderTocreate = args[1];
    	return '<pre class="leet_text" >' + httpGet('terminale.php?mkdir_var=' + dir+ folderTocreate) + '</pre>';
    }else if(args[0] == "rm"){
    	var fileToDelete = args[1];
    	if(args[1] == "-r" || args[1] == "-R"){
    		fileToDelete = args[2];
    		return '<pre class="leet_text" >' + httpGet('terminale.php?rm-r_var=' + dir+ fileToDelete) + '</pre>';
    	}
    	return '<pre class="leet_text" >' + httpGet('terminale.php?rm_var=' + dir+ fileToDelete) + '</pre>';
    }else if(args[0] == "delete" && args[1] == "user"){
    	var userToDelete = args[2];
    	return '<pre class="leet_text" >' + httpGet('terminale.php?sudo_var=' + userToDelete) + '</pre>';
    }else if(args[0] == "print" && args[1] == "db"){
    	return '<pre class="leet_text" >' + httpGet('terminale.php?print_db') + '</pre>';
    }
    // aggiungi printa database

    else return '<pre class="leet_text" >' + $("<p/>").text(cmd).html() + ": command not found</pre>";
}

/*window.setInterval(function() {   // mi porta alla fine del div sempre
  var elem = document.getElementById('data');
  elem.scrollTop = elem.scrollHeight;
}, 100);
*/
$(document).ready(function() {
    $('#cmd_box').keypress(function(e) {
        var cmd = $('#cmd_box').val();
        var cmd1 = $('#cmd_box').val();
        var code = e.keyCode || e.which;
        if (code == 13) { //enter
            $('#cmd_box').val('');
            $('<div class="leet_text" ><font style="color: #FF0000">$</font> ' + $("<p/>").text(cmd).html() + '</div>').insertBefore("#input_div");
            cmd = cmd.trim();
            if (cmd != "") {
                $(processCmd(cmd)).insertBefore("#input_div");
                shell_history.push(cmd);
                shell_history_idx = shell_history.length - 1;
            }
            /*window.scrollTo(0, document.body.scrollHeight);*/
            var elem = document.getElementById('data');
            elem.scrollTop = elem.scrollHeight;
        } else if (code == 38) { //freccia in su
            if (shell_history.length > 0 && shell_history_idx >= 0) {
                $('#cmd_box').val(shell_history[shell_history_idx--]);
            }
        } else if (code == 40) { //freccia in giù
            if (shell_history.length > 0 && shell_history_idx < shell_history.length) {
                if (shell_history.length == shell_history.length - 1)
                    $('#cmd_box').val('');
                else
                    $('#cmd_box').val(shell_history[++shell_history_idx]);
            }
        } else if (code == 9) { // tab
            e.preventDefault();
            var el = commandArr.find(a =>a.includes(cmd));
            cmd = el;
            if(cmd == undefined) cmd = cmd1;
            document.getElementById('cmd_box').value = cmd; // sostituisco con quello trovato
        }
        
    });
});