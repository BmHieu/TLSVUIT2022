(function(Client, $) {
    Client.clearSelection = function() {
        $('.select-item').removeClass('selected');
        $('#statement').val('');
    };

    Client.clearInputValue = function() {
        $('#statement').val('')
    }

    Client.submitStatement = function(){
        const answer = $('#statement').val().toUpperCase()
        Client.answerLog(answer);

        Client.clearSelection();

        var request = $.ajax({
            url: 'server/answer.php',
            method: 'POST',
            data: {
                answerStatement: answer
            },
            dataType: 'json'
        });

        request.done(function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }
        });
    }

    Client.selectAnswer = function(item) {
        item = $(item);
        if (item.hasClass('selected')) {
            return;
        }
        Client.clearSelection();
        Client.clearInputValue();
        item.addClass('selected');

        var index = item.attr('data-text');
        Client.answerLog(index);

        var request = $.ajax({
            url: 'server/answer.php',
            method: 'POST',
            data: {
                answerIndex: index
            },
            dataType: 'json'
        });

        request.done(function(data) {
            if (data.error) {
                alert(data.error);
                return;
            }
        });
    };

    Client.login = function(btn) {
        btn = $(btn);
        var username = $('#username');
        var password = $('#password');
        console.log(username.val(), password.val())
        if (username.val() == '') {
            alert('Vui lòng nhập tên đăng nhập');
            username.focus();
            return;
        }
        if (password.val() == '') {
            alert('Vui lòng nhập mật khẩu');
            password.focus();
            return;
        }

        btn.prop('disabled', true).html('Vui lòng đợi...');

        var request = $.ajax({
            url: 'server/login.php',
            method: 'POST',
            data: {
                username: username.val(),
                password: password.val()
            },
            dataType: 'json'
        });

        request.done(function(data) {
            if (data.error) {
                btn.prop('disabled', false).html('Đăng nhập');
                alert(data.error);
                return;
            }
            window.location.reload();
        });
    };

    Client.answerLog = function(index) {
        var logs = Client.getAnswerLogs();
        if (logs.length >= 5) {
            logs.shift();
        }
        logs.push({
            index: index,
            time: Date.now()
        });

        Client.setCookie('answer_logs', JSON.stringify(logs), 1);
    };

    Client.answerMapping = ['A', 'B', 'C', 'D'];
    Client.showLogs = function() {
        var logs = Client.getAnswerLogs();
        var msg = ["Lịch sử chọn: "];
        for (var i = 0; i < logs.length; i++) {
            let answer = Client.answerMapping[logs[i].index] ? Client.answerMapping[logs[i].index] : logs[i].index;
            msg.push("Chọn " + answer + ' lúc ' + Client.formatTime(logs[i].time));
        }
        alert(msg.join("\n"));
    };

    Client.getAnswerLogs = function() {
        var data = Client.getCookie('answer_logs');
        if (data) {
            data = JSON.parse(data);
            return data;
        }
        return [];
    };

    Client.formatTime = function(ts) {
        var date = new Date(ts);
        // Hours part from the timestamp
        var hours = date.getHours();
        // Minutes part from the timestamp
        var minutes = "0" + date.getMinutes();
        // Seconds part from the timestamp
        var seconds = "0" + date.getSeconds();

        // Will display time in 10:30:23 format
        return hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2) + ' - ' + date.getMilliseconds();
    };

    Client.setCookie = function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires + "; path=/;";
    };

    Client.getCookie = function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for(var i=0; i<ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1);
            if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
        }
        return "";
    };
})(window.Client = window.Client || {}, jQuery);