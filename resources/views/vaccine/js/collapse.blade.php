<script>
    function submitVacForm() {
        loading(true);
        clearErrors();
    
        var postInfo = requestInfo();
    
        $.post('/vaccine/add', postInfo, function(data) {
            loading(false);
            if (data.status == 'success') {
                document.getElementById('js-no-vaccine-alert').style.display = 'none';
                document.getElementById('js-vaccine-section').innerHTML = document.getElementById('js-vaccine-section').innerHTML + data.html;
                $('#vaccineCollapse').collapse('hide');
            } else {
                showErrors(data.errors);
            }
        }, 'json');
    }
    
    function loading(is) {
        if (is) {
            document.getElementById("vacBtn").style.display = 'none';
            document.getElementById("vacLoadingBtn").style.display = '';
        } else {
            document.getElementById("vacBtn").style.display = '';
            document.getElementById("vacLoadingBtn").style.display = 'none';
        }
    }
    
    function requestInfo() {
        return {
            '_token' : $('meta[name=csrf-token]').attr('content'),
            'registrationId' : document.getElementById('registrationId').value,
            'lotNumber' : getRadio('lotNumber'),
            'injectionSite' : getRadio('injectionSite'),
            'eligibility' : getRadio('eligibility'),
            'risks' : getRisks(),
        }
    }
    
    function getRisks() {
        var checkboxes = document.getElementsByClassName('js-risk');
        var checked = [];
        for (var i=0; i<checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                checked.push(checkboxes[i].dataset.risk);
            }
        }
        return checked;
    }

    function getRadio(name) {
        return document.querySelector('input[name="' + name + '"]:checked').value;
    }
    
    function showErrors(errors) {
        let errorBlock = document.getElementById('vaccineErrors');
        let errorList = "ERROR:";
        if (errorBlock.classList.contains('d-none')) {
            errorBlock.classList.remove('d-none');
        }
        for (const prop in errors) {
            errorList = errorList + "\r\n" + errors[prop][0];
        }
        errorBlock.innerHTML = errorList;
    }
    
    function clearErrors() {
        let errorBlock = document.getElementById('vaccineErrors');
        if (!errorBlock.classList.contains('d-none')) {
            errorBlock.classList.add('d-none');
        }
    }
    </script>