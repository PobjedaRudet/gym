/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!*******************************!*\
  !*** ./resources/js/main2.js ***!
  \*******************************/
/* $(document).ready(function () {

  $("#sifra").on("keydown", function (event) {
      if (event.which == 13) {
          // var id = Number($('#sifra').val().trim());
          var idss = String($("#sifra").val().trim());
          console.log(idss);
          var id = idss.replace(/\&/g, '/');
            
          $("#sifra").val("");
      }
  });



  // KRAJ FETCHOVANJA PODATAKA U TABELU
}); */

document.querySelector('#sifra').addEventListener('keypress', function (e) {
  if (e.key === 'Enter') {
    var postObj = {
      id: $("#sifra").val(),
      gym: 2,
      title: "What is AJAX",
      body: "AJAX stands for Asynchronous JavaScript..."
    };
    $("#sifra").val("");
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      /* the route pointing to the post function */
      url: 'slanje',
      async: false,
      type: 'POST',
      /* send the csrf-token and the input to the controller */
      data: {
        _token: CSRF_TOKEN,
        postObj: postObj
      },
      dataType: 'JSON',
      /* remind that 'data' is the response of the AjaxController */
      success: function success(data) {
        console.log(data);
        var id = data['id'];
        if (id == 0 || id == 1) {
          /* Datum isteka članarine */
          var end = data['response'][0].end;

          /* Slika člana */
          var picture = data['response'][0].image_path;
          var name = data['response'][0].name;

          /* Kreiranje trenutnog datuma */
          var d = new Date();
          var month = d.getMonth() + 1;
          var day = d.getDate();
          var trenutni_datum = d.getFullYear() + '-' + (('' + month).length < 2 ? '0' : '') + month + '-' + (('' + day).length < 2 ? '0' : '') + day;

          /* Provjera isteka članarine */
          if (trenutni_datum <= end) {
            console.log('Članarina nije istekla');
            console.log(id);
            $('#okvir').removeClass("bg-danger");
            //$('#okvir').addClass("bg-success");
            //$('#okvir').css("background-color", "#89F457");
            $("#status").text('');
            $("#status").text('ČLANARINA JE PLAĆENA');
            if (id == 0) {
              $("#status").text('');
              $('#inout').removeClass("bg-warning");
              $('#inout').removeClass("bg-danger");
              $("#inout").text('PRIJAVA').addClass("bg-success font-weight-bold rounded");
              var surname = data['response'][0].surname;
              $("#sifra").val("");
              $("#rok").text('Članarina traje do: ' + data['rok']);
              $("#name").text(name + ' ' + surname);
              console.log(name);
              $("#pic").attr('src', 'images/' + picture);
            } else if (id == 1) {
              $("#status").text('');
              $("#rok").text('');
              $('#inout').removeClass("bg-danger");
              $('#inout').removeClass("bg-success");
              $("#inout").text('ODJAVA').addClass("bg-warning font-weight-bold rounded");
              var surname = data['response'][0].surname;
              $("#sifra").val("");
              $("#name").text(name + ' ' + surname);
              console.log(name);
              $("#pic").attr('src', 'images/' + picture);
            }
          }
        } else {
          console.log('Članarina je istekla');
          $("#name").text('');
          $("#rok").text('');
          $("#pic").attr('src', 'images/avatar.jpg');
          $('#okvir').removeClass("bg-success");
          // $('#okvir').addClass("bg-danger"); // crvena #F3522E
          $("#status").text('');
          $("#status").addClass("text-white").addClass("bg-danger font-weight-bold rounded");
          $("#status").text('ČLANARINA JE ISTEKLA');
          $("#inout").text('NE MOŽETE SE PRIJAVITI').addClass("bg-danger text-white font-weight-bold rounded");
        }
      }
    });
  }
});
/******/ })()
;