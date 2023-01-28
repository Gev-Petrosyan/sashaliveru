$( document).ready(function() {
  
  const date = new Date();
  let month = date.getMonth()+1;
  let year = date.getFullYear();
  
  const footer_title = $("#footer_title");
  
  const fc_buttons_group = $(".fc-button-group button");
  const todayButton = $(".fc-toolbar-chunk button[title='This month']");

  const dataTbody = $("#dataTbody");

  $.ajax({
    url: 'php/requests/',
    method: 'POST',
    data: {
      month: month,
      year: year
    },
    success: function(data){
      if (data) {
          data.forEach(tr => {
            let from_date = tr.from_date;
            let to_date = tr.to_date;
  
            let monthBlockOne = $("td").find(`[data-date='${from_date}']`);
            monthBlockOne.addClass('tournament-day');
            monthBlockOne.children('.fc-daygrid-day-frame').children('.fc-daygrid-day-events').html('<div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future"><div class="fc-daygrid-event-dot"></div><div class="fc-event-title" style="font-size:12px">'+tr.title+'</div></a></div><div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>');
  
            let date = '';

            if (to_date) {
              let monthBlockTwo = $("td").find(`[data-date='${to_date}']`);
              monthBlockTwo.addClass('tournament-day');
              monthBlockTwo.children('.fc-daygrid-day-frame').children('.fc-daygrid-day-events').html('<div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future"><div class="fc-daygrid-event-dot"></div><div class="fc-event-title" style="font-size:12px">'+tr.title+'</div></a></div><div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>');
              let formatFromDate = tr.from_date.slice(8, 10) + '.' + tr.from_date.slice(5, 7) + '.' + tr.from_date.slice(2, 4)
              + ' - ' + tr.to_date.slice(8, 10) + '.' + tr.to_date.slice(5, 7) + '.' + tr.to_date.slice(2, 4);
              date = formatFromDate
            } else {
              let formatFromDate = tr.from_date.slice(8, 10) + '.' + tr.from_date.slice(5, 7) + '.' + tr.from_date.slice(2, 4);
              date = formatFromDate;
            }

            let html = `
              <tr>
                <td>${date}</td>
                <td><a href="tournament.php?id=${tr.id}">${tr.title}</a></td>
                <td>${tr.classes}</td>
              </tr>
            `;
            dataTbody.append(html);
          });
      }
    }
  });
  
  fc_buttons_group.on('click', function() {
    if ($(this).attr('title') == "Previous month") {
      month--;
      if (month < 1) {
        month = 12;
        year--;
      }
    } else {
      month++
      if (month > 12) {
        month = 1;
        year++;
      }
    }
    requestCalendar(month, year);
  });

  todayButton.on('click', function() {
    month = date.getMonth()+1;
    year = date.getFullYear();
    requestCalendar(month, year);
  });

  function requestCalendar(month, year) {
    setHTML();

    $.ajax({
      url: 'php/requests/',
      method: 'POST',
      data: {
        month: month,
        year: year
      },
      success: function(data) {
        if (data) {
            data.forEach(tr => {
              let date = '';

              if (tr.to_date) {
                let formatFromDate = tr.from_date.slice(8, 10) + '.' + tr.from_date.slice(5, 7) + '.' + tr.from_date.slice(2, 4)
                + ' - ' + tr.to_date.slice(8, 10) + '.' + tr.to_date.slice(5, 7) + '.' + tr.to_date.slice(2, 4);
                date = formatFromDate
              } else {
                let formatFromDate = tr.from_date.slice(8, 10) + '.' + tr.from_date.slice(5, 7) + '.' + tr.from_date.slice(2, 4);
                date = formatFromDate;
              }

              let html = `
                <tr>
                    <td>${date}</td>
                    <td><a href="tournament.php?id=${tr.id}">${tr.title}</a></td>
                    <td>${tr.classes}</td>
                </tr>
              `;

              dataTbody.append(html);

              let from_date = tr.from_date;
              let to_date = tr.to_date;
    
              let monthBlockOne = $("td").find(`[data-date='${from_date}']`);
              monthBlockOne.addClass('tournament-day');
              monthBlockOne.children('.fc-daygrid-day-frame').children('.fc-daygrid-day-events').html('<div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future"><div class="fc-daygrid-event-dot"></div><div class="fc-event-title" style="font-size:12px">'+tr.title+'</div></a></div><div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>');
    
              if (to_date) {
                let monthBlockTwo = $("td").find(`[data-date='${to_date}']`);
                monthBlockTwo.addClass('tournament-day');
                monthBlockTwo.children('.fc-daygrid-day-frame').children('.fc-daygrid-day-events').html('<div class="fc-daygrid-event-harness" style="margin-top: 0px;"><a class="fc-daygrid-event fc-daygrid-dot-event fc-event fc-event-draggable fc-event-resizable fc-event-start fc-event-end fc-event-future"><div class="fc-daygrid-event-dot"></div><div class="fc-event-title" style="font-size:12px">'+tr.title+'</div></a></div><div class="fc-daygrid-day-bottom" style="margin-top: 0px;"></div>');
              }
            })
        }
      }
    });

  }

  function setHTML() {
    footer_title.text('В ЭТОМ МЕСЯЦЕ');
    dataTbody.html('');
  }


})