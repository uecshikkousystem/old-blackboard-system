(function WriteSubjectName(na) {
  document.getElementById('subject-name').innerHTML = "";

  if (document.form.faculty[0].checked) {
    var subject = {
      'C': '情報通信工学科',
      'J': '情報工学科',
      'E': '電子工学科',
      'F': '量子・物質工学科',
      'M': '知能機械工学科',
      'T': 'システム工学科',
      'H': '人間コミュニケーション学科'
    };
  } else if (document.form.faculty[1].checked) {
    var subject = {
      'J': '総合情報学科',
      'I': '情報・通信工学科',
      'M': '知能機械工学科',
      'S': '先進理工学科',
      'K': '先端工学基礎課程'
    };
  }
  alert(na);
}());

function ChangeSubject() {
    subjectObj = document.getElementById("subject-in");
    gradeObj = document.getElementById("grade-in");
    subjectObj.innerHTML = "";
    gradeObj.innerHTML = "";

    if (document.form.faculty[0].checked) {
        var subject = {
            'J': '総合情報学科',
            'I': '情報・通信工学科',
            'M': '知能機械工学科',
            'S': '先進理工学科',
            'K': '先端工学基礎課程'
        };
        var grade = {
            '1': 'grade-1',
            '2': 'grade-2',
            '3': 'grade-3',
            '4': 'grade-4'
        };
    } else if (document.form.faculty[1].checked) {
        var subject = {
            'Ⅰ': 'Ⅰ類',
            'Ⅱ': 'Ⅱ類',
            'Ⅲ': 'Ⅲ類',
      	    'その他':'その他'
        };
	var grade = {
            '1': 'grade-1',
            '2': 'grade-2',
            '3': 'grade-3',
            '4': 'grade-4'
        };
    } else if (document.form.faculty[2].checked) {
      var subject = {
          'その他':'その他'
      };
var grade = {
          '1': 'grade-1',
          '2': 'grade-2',
          '3': 'grade-3',
          '4': 'grade-4',
          'その他':'grade-sonota'
      };
  }

  var isfirst=true;
    for (var i in subject) {
        var inputObj = document.createElement("input");
        inputObj.setAttribute("type", "radio");
        inputObj.setAttribute("id", i);
        inputObj.setAttribute("name", "subject");
        inputObj.setAttribute("value", i);
        inputObj.setAttribute("title", subject[i]);
        if(isfirst) inputObj.setAttribute("checked", '');
        isfirst=false;
        subjectObj.appendChild(inputObj);

        var labelObj = document.createElement("label");
        labelObj.setAttribute("for", i);
        labelObj.setAttribute("title", subject[i]);
        labelObj.appendChild(document.createTextNode(i));
        subjectObj.appendChild(labelObj);
    }
    isfirst=4;
    for (var i in grade) {
        var inputObj = document.createElement("input");
        inputObj.setAttribute("type", "radio");
				inputObj.setAttribute("name", "grade");
        inputObj.setAttribute("id", grade[i]);
        inputObj.setAttribute("value", i);
        if(isfirst==0) inputObj.setAttribute("checked", '');
        isfirst--;
        gradeObj.appendChild(inputObj);

        var labelObj = document.createElement("label");
        labelObj.setAttribute("for", grade[i]);
        labelObj.appendChild(document.createTextNode(i));
        gradeObj.appendChild(labelObj);
    }

};
