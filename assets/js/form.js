function formLabel(group, span) {
    group.style.border = '#6DA926 solid 2px'
    span.style.color = '#6DA926';
    span.style.top = '-12px';
    span.style.fontSize = '.9em';
    span.style.transition = '.4s';
}

function formPlaceholder(group, span, input) {
    if (input.value == "") {
        span.style.top = '8px';
        span.style.fontSize = '1.1em';
        span.style.transition = '.4s';
    }

    group.style.border = 'grey solid 2px'
    span.style.color = 'grey';
}

function formInvalid(bool, group, span, input) {
    if(!bool) {
        group.style.border = 'red solid 2px'
        span.style.color = 'red';
    }

    if (input.value != '') {
        span.style.top = '-12px';
        span.style.fontSize = '.9em';
        span.style.transition = '.4s';
    }
}

function lookPassword(input) {

    if (input.getAttribute('type') == 'password') {
        input.setAttribute('type', 'text')
    } else {
        input.setAttribute('type', 'password')
    }
}