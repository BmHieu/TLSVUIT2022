(function (Creator, $) {
    Creator.removeQuiz = (btn) => {
        btn = $(btn)
        var questionBox = $('#questionBoxNumber');
        var questionNum = $('#questionNumber');
        if (questionBox.val() == '') {
            alert('Vui lòng nhập chỉ số bộ câu hỏi.');
            questionBox.focus();
            return;
        }
        if (questionNum.val() == '') {
            alert('Vui lòng nhập chỉ số câu hỏi.');
            questionNum.focus();
            return;
        }

        var request = $.ajax({
            url: 'server/remove.php',
            method: 'POST',
            data: {
                questionBox: questionBox.val(),
                questionNum: questionNum.val()
            },
            dataType: 'json'
        });

        btn.prop('disabled', true).html('Vui lòng đợi...');

        request.done(data => {
            console.log(data)
            if (data.error) {
                btn.prop('disabled', false).html('Xóa');
                alert(data.error);
                return;
            }
            location.reload()
        })

    }

    Creator.addQuiz = (btn) => {
        btn = $(btn);

        var questionBox = $('#questionBoxNumber');
        var questionNum = $('#questionNumber');
        var question = $('#question');
        var answers = $("input[name='answer[]']")
            .map(function () {
                return $(this).val();
            }).get();
        var selectedIndex = $(".subSelector").index($(".subSelector:checked"));

        if (questionBox.val() == '') {
            alert('Vui lòng nhập chỉ số bộ câu hỏi.');
            questionBox.focus();
            return;
        }
        if (questionNum.val() == '') {
            alert('Vui lòng nhập chỉ số câu hỏi.');
            questionNum.focus();
            return;
        }
        if (question.val() == '') {
            alert('Vui lòng nhập câu hỏi.');
            question.focus();
            return;
        }
        var index = answers.indexOf('')
        if (index > -1) {
            alert('Vui lòng nhập câu trả lời số ' + (index + 1));
            return;
        }
        if (selectedIndex === -1) {
            alert('Vui lòng chọn đáp án đúng.');
            return;
        }

        btn.prop('disabled', true).html('Vui lòng đợi...');

        var request = $.ajax({
            url: 'server/questions.php',
            method: 'POST',
            data: {
                questionBox: questionBox.val(),
                questionNum: questionNum.val(),
                question: question.val(),
                answers: answers,
                correct: selectedIndex
            },
            dataType: 'json'
        });

        request.done(data => {
            btn.prop('disabled', false).html('Submit');
            if (data.error) {
                alert(data.error);
                return;
            }
            alert('Cập nhật nội dung câu hỏi thành công!');
        })
    };

    Creator.loadQuestions = () => {
        var request = $.ajax({
            url: 'server/questions.php',
            method: 'GET',
            data: {},
            dataType: 'json'
        });

        request.done(function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }
            console.log(data)
            Creator.questions = data.data;
            Creator.showQuestionList();
        });
    }

    Creator.showQuestionList = () => {
        for (i = 0; i < 5; i++) {
            var pannel_group = $('.panel-group')
            var panel = $('<div/>')
            panel.addClass('panel panel-default')
            panel.appendTo(pannel_group)
            var questionBox = '#questionBox' + i
            var item = $('<button/>')
            item.prop('type', 'button')
            item.addClass("btn questionBox-name")
            item.attr('data-toggle', 'collapse')
            item.attr('data-target', questionBox)
            item.html("Bộ số " + (i + 1))
            item.appendTo(panel)
            Creator.appendButtonCallQuestions(i, panel)
        }
    }

    Creator.appendButtonCallQuestions = (boxNumber, panel) => {
        var questionBox = 'questionBox' + boxNumber
        var div = $('<div/>')
        div.attr('id', questionBox)
        div.addClass('collapse')
        div.attr('data-parent', '#accordion')
        div.appendTo(panel)
        Creator.appendQuestion(boxNumber, div)
    }

    Creator.appendQuestion = (boxNumber, div) => {
        for (var i = 0; i < Creator.questions[boxNumber].length; i++) {
            var item = $('<button/>')
            item.prop('type', 'button')
            item.addClass("btn question")
            item.attr('value', boxNumber + "_" + i)
            item.attr('onclick', 'Creator.loadQuestion(this);')
            item.html('Câu hỏi ' + (i + 1))
            item.appendTo(div)
        }
    }

    Creator.loadQuestion = (btn) => {
        btn = $(btn);
        var box = btn.attr('value').split('_')[0]
        var index = btn.attr('value').split('_')[1]
        $("#questionNumber").val(Number(index) + 1)
        $("#questionBoxNumber").val(Number(box) + 1)
        $("#question").html(Creator.questions[box][index]['question'])
        var answerIndex = 0
        $("input[name='answer[]']")
            .map(function () {
                $(this).val(Creator.questions[box][index]['answers'][answerIndex++]);
            })
        $(".subSelector")
            .map(function (indexChoice) {
                if (indexChoice === Creator.questions[box][index]['correct']) {
                    $(this).prop("checked", true);
                }
            })
    }

    Creator.saveConfig = (btn) => {
        btn = $(btn);
        let data = {}
        Creator.keyNames = $("input[name='info[keyName]']").map(function () {return $(this).val()}).get()
        Creator.keyNames.map(keyName=>{
            let selector =  `input[name='info[${keyName}]']`
            const value = ($(selector).map(function () {return $(this).val()}).get())
            data[keyName] = {
                "matkhau": value[0],
                "ten": value[1],
                "shortName": value[2],
                "diem": 0
            }
        })
        var countdown = $('#countdown').val();
        var scoreRange = $('#scoreRange').val();

        console.log(countdown, scoreRange)
        var request = $.ajax({
            url: 'server/config.php',
            method: 'POST',
            data: {
                infoTeam: data,
                countdown: countdown,
                scoreRange: scoreRange
            },
            dataType: 'json'
        });
        request.done(function (data) {
            if (data.error) {
                alert(data.error);
                return;
            }
            window.location.reload()
        });
    }

    Creator.init = () => {
        Creator.loadQuestions();
    }
})(window.Creator = window.Creator || {}, jQuery);