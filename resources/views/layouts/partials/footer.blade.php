
  <footer class="footer">
    <div class="footer_top">
      <div class="container">
        <div class="row">
          <div class="col-xl-4 col-md-6 col-lg-8">
            <div class="footer_widget">
              <div class="footer_logo">
                <span>
                  {{config('app.name')}}
                </span>
              </div>
              <p>
                Let’s get visible is a digital marketing agency which helps small and medium businesses sell online by
                taking control of their online visibility. Its aim is to equip customers with all the knowledge needed
                to take control of online presence and get the customers and desired sales.
              </p>
              <div class="">
                <ul>
                  <li>
                    <a href="https://letsgetvisible.com.au/">
                      Visit Site
                    </a>
                  </li>
                </ul>
              </div>

            </div>
          </div>
          <div class="col-xl-4 col-md-6 col-lg-4">
            <div class="footer_widget">
              <h3 class="footer_title">
                Services
              </h3>
              <ul>
                <li><a href="{{route('main')}}">SEO Audit</a></li>
                <li><a href="{{route('reviews')}}">Reviews</a></li>
                <li><a href="{{route('competitorsdomain')}}">Competitors Domain</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="copy-right_text">
      <div class="container">
        <div class="footer_border"></div>
        <div class="row">
          <div class="col-xl-12">
            <p class="copy_right text-center">
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
              Copyright &copy;
              <script>document.write(new Date().getFullYear());</script> All rights reserved | {{
              strtoupper(config('app.name'))}}
              <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

  <!-- JS here -->
  <script src="{{ asset('frontend/js/vendor/modernizr-3.5.0.min.js') }}"></script>
  <script src="{{ asset('frontend/js/vendor/jquery-1.12.4.min.js') }}"></script>
  <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
  <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
  <script src="{{ asset('frontend/js/isotope.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/js/ajax-form.js') }}"></script>
  <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.counterup.min.js') }}"></script>
  <script src="{{ asset('frontend/js/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('frontend/js/scrollIt.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.scrollUp.min.js') }}"></script>
  <script src="{{ asset('frontend/js/wow.min.js') }}"></script>
  <script src="{{ asset('frontend/js/nice-select.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.slicknav.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('frontend/js/plugins.js') }}"></script>
  <script src="{{ asset('frontend/js/gijgo.min.js') }}"></script>

  <!--contact js-->
  <script src="{{ asset('frontend/js/contact.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.ajaxchimp.min.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
  <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('frontend/js/mail-script.js') }}"></script>

  <script src="{{ asset('frontend/js/main.js')}}"></script>

  <script>
  const showLoader = () => {
    $('.loading').removeClass('hidden');
    $('.case_study_area').addClass('opacity');
    $('button[type=submit]').attr("disabled", true);
  }

  const hideLoader = () => {
    $('.loading').addClass('hidden');
    $('.case_study_area').removeClass('opacity');
    $('button[type=submit]').attr("disabled", false);
  }

  const validateDomain = () => {
    let domain = $('#domain').val();
    // (!/^(http(s)?\/\/:)?(www\.)?[a-zA-Z0-9\-]{3,}(\.[a-z]+(\.[a-z]+)?)$/.test(domain))
    if(domain == "")
    {
      console.log('Required Field');
      $('#domain').addClass('hasDomainError');
      $('.errField').removeClass("hidden");
      return false;
    }
    $('.errField').addClass("hidden");
    $('#domain').removeClass('hasDomainError');
    return true;
  }
  $('#domain').keyup(function(){
    validateDomain();
  });

  const buildStatisticsView = (responseObj) => {
    Object.keys(responseObj).map(function(element, index) {
      if(element=="OnPage Score"){
        $('.seoScoreDiv').html(`<div style="transform: translate3d(0px, 0px, 0px) scale3d(1, 1, 1) rotateX(0deg) rotateY(0deg) rotateZ(0deg) skew(0deg, 0deg);opacity: 1;transform-style: preserve-3d;" class="feature-block"><h3><strong>${element}<br/> ${responseObj[element]} </strong></h3></div>`);
      }else{
        $('.seoDetailsDiv').append(`<div class="col-md-4">  <div class="px-4 py-5 mt-5 sm:p-6" style="background: beige;">    <h3 class="text-sm font-medium text-gray-500 truncate">${element}</h3>    <p class="mt-1 text-3xl font-semibold text-gray-600">${responseObj[element]} </p>  </div></div>`);
      }
    })
  }
  const buildAdditionalChecksView = (responseObj, id) => {
    Object.keys(responseObj).map(function(element, index) {

        $('.seoDetailsDiv').append(`<div class="col-md-4">  <div class="px-4 py-5 mt-5 sm:p-6" style="background: beige;">    <h3 class="text-sm font-medium text-gray-500 truncate">${element}</h3>    <p class="mt-1 text-3xl font-semibold text-gray-600">${responseObj[element]} </p>  </div></div>`);
    })
    let detailUrl = "{{route('fullPageStatistics', [':reqId'])}}";
    detailUrl = detailUrl.replace(":reqId", id);
    $('.seoDetailsDiv').append(`<div class='row'><div class='col-12'><a href='${detailUrl}'> <button id='additionCheck' class="btn btn-primary btn-lg">View Full Page Statistics</button></a> </div></div>`)
  }

  const buildAdditionalView = (responseObj) => {
    let metaDiv = '';
    let meta = null;
    if(responseObj.Meta) meta = Object.keys(responseObj.Meta).map(index => { metaDiv += `<div class="row"><div class='col-md-3'>${index}</div><div class='col-md-9'>${responseObj.Meta[index]}</div></div>`});
    let hDiv = '';
    let hTags = null;
    if(responseObj.Htags) hTags = Object.keys(responseObj.Htags).map(index => { hDiv += `<div class='row'><div class='col-md-3'>${index}</div><div class='col-md-9'>${responseObj.Htags[index].map(el => {return `<span>${el}</span>`})}</div></div>`});
    
    let performanceDiv = '';
    let performance = Object.keys(responseObj['Page Timing']).map(index => { performanceDiv+= `<div class='row'><div class='col-md-3'>${index}</div><div class='col-md-9'>${responseObj['Page Timing'][index]}</div></div>`});

    let view = `<div class="seoAdditionalDetails">
      <div class="card">
        <div class="card-title"><h2>Meta</h2></div>
        <div class="card-body">
          ${metaDiv}
        </div>
      </div>
      <div class="card">
        <div class="card-title"><h2>Htags</h2></div>
        <div class="card-body">
        ${hDiv}
        </div>
      </div>
      <div class="card">
        <div class="card-title"><h2>Page Timing</h2></div>
        <div class="card-body">
        ${performanceDiv}
        </div>
      </div>
    </div>`;

    $('.seoDetailsDiv').append(view)
  }

  $(document).on('click', '#additionCheck', function(e){
    e.preventDefault();
    let current = $(this);
    current.hide();
    let url = current.parent()[0].href;

    $.ajax({
      type: 'GET',
      url: url,
      beforeSend: function () {
        showLoader();
      },
      success: function (response) {
        if(response?.message) alert(response?.message);
        if(response.status == 200){
          buildAdditionalView(response.details);
          hideLoader();
          return;
        }
        hideLoader();

      },
      error: function (xhr) {
        hideLoader();
        if(xhr.status == 422){
          alert(xhr.responseJSON.errors.domain[0]);
          return;
        }
        alert("Some Error Occured while processing your request.");
      },
      complete: function () {
        console.log("Complete")
      }
    });
  });

  const getPageSummary = (action, requestId) => {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
      },
      type: 'POST',
      url: action,
      data: {id: requestId},
      beforeSend: function () {
        $('.seoScoreDiv').html("")
        $('.seoDetailsDiv').html("")
        showLoader();
      },
      success: function (response) {
        if(response.status_code == 202){
          setTimeout(() => {
            getPageSummary(action, requestId)
          }, 10000)
          return;
        }else if(response.status_code == 200){
          alert(response.message);
          let statistics = response.statistics;
          $('.seoDetailsDiv').html("")
          buildStatisticsView(statistics)
          @auth
          buildAdditionalChecksView(response.extra_stats, response.id)
          @endif
          hideLoader();
        }else{
          alert(response.message);
          hideLoader();
        }

      },
      error: function (xhr) {
        hideLoader();
        if(xhr.status == 422){
          alert(xhr.responseJSON.errors.domain[0]);
          return;
        }
        alert("Some Error Occured while processing your request.");
      },
      complete: function () {
        console.log("Complete")
      }
    });
  }

  $('#website-form').submit(function(e){
    e.preventDefault();
    let canSubmitForm = validateDomain();
    let current = $(this);

    if(canSubmitForm){
      $.ajax({
        type: 'POST',
        url: current[0].action,
        data: current.formSerialize(),
        beforeSend: function () {
          $('.seoScoreDiv').html("")
          $('.seoDetailsDiv').html("")
          showLoader();
        },
        success: function (response) {
          alert(response.message);
          if(response.status_code == 202){
            setTimeout(() => {
              getPageSummary(current[0].action, response.id)
            }, 10000)
            return;
          }else if(response.status_code == 200){
            let statistics = response.statistics;
            $('.seoDetailsDiv').html("")
            buildStatisticsView(statistics)
            @auth
            buildAdditionalChecksView(response.extra_stats, response.id)
            @endif
            hideLoader();
          }else if(response.status_code == 401){
            hideLoader();
          }

        },
        error: function (xhr) {
          hideLoader();
          if(xhr.status == 422){
            alert(xhr.responseJSON.errors.domain[0]);
            return;
          }
          alert("Some Error Occured while processing your request.");
        },
        complete: function () {
          console.log("Complete")
        }
      });
    }
  });

  const buildReviewView = data => {
    let dataDiv = '';
    let meta = Object.keys(data).map(index => {
      if(index == "Rating"){
        let ratingData = '';
        Object.keys(data[index]).map(ind => {
          ratingData += `<span>${ind} => </span>&nbsp&nbsp<span>${data[index][ind]}</span><br />`
        })
        dataDiv += `<div class="row"><div class='col-md-3'>${index}</div><div class='col-md-9'>${ratingData}</div></div>`
      } else{

        dataDiv += `<div class="row"><div class='col-md-3'>${index}</div><div class='col-md-9'>${data[index]}</div></div>`
      }
    });
    $('.seoDetailsDiv').html(`<div class="card">
            <div class="card-title"><h2>${data.Title}</h2></div>
            <div class="card-body">
            ${dataDiv}
            </div>
          </div>`)
  }

  const getReviewSummary = (action, requestId) => {
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': "{{csrf_token()}}"
      },
      type: 'POST',
      url: action,
      data: {id: requestId},
      beforeSend: function () {
        $('.seoScoreDiv').html("")
        $('.seoDetailsDiv').html("")
        showLoader();
      },
      success: function (response) {
        if(response.status_code == 202){
          setTimeout(() => {
            getReviewSummary(action, requestId)
          }, 10000)
          return;
        }else if(response.status_code == 200){
          alert(response.message);
          let statistics = response.statistics;
          $('.seoDetailsDiv').html("")
          buildReviewView(response.data)
          hideLoader();
        }else{
          alert(response.message);
          hideLoader();
        }

      },
      error: function (xhr) {
        hideLoader();
        if(xhr.status == 422){
          alert(xhr.responseJSON.errors.domain[0]);
          return;
        }
        alert("Some Error Occured while processing your request.");
      },
      complete: function () {
        console.log("Complete")
      }
    });
  }

  $('#keyword-form').submit(function(e){
    e.preventDefault();
    let current = $(this);
    let action = current[0].action;

    $.ajax({
      type: 'POST',
      url: action,
      data: current.formSerialize(),
      beforeSend: function () {
        $('.seoScoreDiv').html("")
        $('.seoDetailsDiv').html("")
        showLoader();
      },
      success: function (response) {
        alert(response.message);
        if(response.status_code == 202){
          setTimeout(() => {
            getReviewSummary(action, response.id)
          }, 10000)
          return;
        }else if(response.status_code == 200){
          let statistics = response.statistics;
          $('.seoDetailsDiv').html("")

          buildReviewView(response.data)
          hideLoader();
        }else if(response.status_code == 401){
          hideLoader();
        }

      },
      error: function (xhr) {
        hideLoader();
        if(xhr.status == 422){
          alert(xhr.responseJSON.errors.domain[0]);
          return;
        }
        alert("Some Error Occured while processing your request.");
      },
      complete: function () {
        console.log("Complete")
      }
    });
  });

  const buildCompetitorView = (data) => {
    data.forEach(el => $('.seoScoreDiv').append(`<div class="card">
      <div class="card-title"><h2>${el}</h2></div>
    </div>`))
  }


  $('#competitor-form').submit(function(e){
    e.preventDefault();
    let current = $(this);
    let action = current[0].action;

    $.ajax({
      type: 'POST',
      url: action,
      data: current.formSerialize(),
      beforeSend: function () {
        $('.seoScoreDiv').html("")
        $('.seoDetailsDiv').html("")
        showLoader();
      },
      success: function (response) {
        alert(response.message);
        if(response.status_code == 200){
          let statistics = response.statistics;
          $('.seoDetailsDiv').html("")
          buildCompetitorView(response.data)
          hideLoader();
        }else if(response.status_code == 401){
          hideLoader();
        }

      },
      error: function (xhr) {
        hideLoader();
        if(xhr.status == 422){
          alert(xhr.responseJSON.errors.domain[0]);
          return;
        }
        alert("Some Error Occured while processing your request.");
      },
      complete: function () {
        console.log("Complete")
      }
    });
  });

  </script>
