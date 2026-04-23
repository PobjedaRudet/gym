
$(document).ready(function () {

  var clockIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>';

  const osvjezi = () => {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
      url: 'live',
      type: 'POST',
      data: { _token: CSRF_TOKEN },
      dataType: 'JSON',
      success: function (data) {
        var items = data['response'];
        $('#live').empty();
        var gymCount = items.filter(function(x){ return x.gym == 1; }).length;
        var ladiesCount = items.filter(function(x){ return x.gym != 1; }).length;
        $('#counter-gym').text('Gym: ' + gymCount);
        $('#counter-ladies').text('Ladies Gym: ' + ladiesCount);
        $('#live-counter').text('Ukupno: ' + items.length);

        if (items.length === 0) {
          $('#live').append(
            '<div class="col-12 empty-state">' +
              '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128H5.228A2 2 0 013 17.208V17a6.002 6.002 0 017.002-5.917A6.002 6.002 0 0117 17v.128zM12 10a4 4 0 100-8 4 4 0 000 0z"/></svg>' +
              '<p>Nema prijavljenih članova</p>' +
            '</div>'
          );
          return;
        }

        for (var i = 0; i < items.length; i++) {
          var d = items[i];
          var date_parts = d["in"].split(' ');
          var gymClass = d.gym == 1 ? 'gym-1' : 'gym-2';
          var gymLabel = d.gym == 1 ? 'Gym' : 'Ladies Gym';

          var card =
            '<div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-6">' +
              '<div class="member-card">' +
                '<div class="card-img-wrapper">' +
                  '<span class="gym-badge ' + gymClass + '">' + gymLabel + '</span>' +
                  '<a href="memberProfile/' + d.ids + '">' +
                    '<img src="' + base_url + '/' + d.image_path + '" alt="' + d.name + '">' +
                  '</a>' +
                '</div>' +
                '<div class="card-body">' +
                  '<div class="member-name" title="' + d.name + ' ' + d.surname + '">' + d.name + ' ' + d.surname + '</div>' +
                  '<div class="member-time">' + clockIcon + ' ' + date_parts[1] + '</div>' +
                '</div>' +
                '<div class="card-actions">' +
                  '<a href="odjava-live/' + d.id + '" class="btn-odjava ' + gymClass + '">Odjavi</a>' +
                '</div>' +
              '</div>' +
            '</div>';

          $('#live').append(card);
        }
      }
    });
  };

  osvjezi();
  setInterval(osvjezi, 2000);

});


