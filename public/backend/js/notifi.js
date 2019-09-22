/**
 * Created by Toinn
 */
function notifyInfo(msg) {
    new Noty({
        type: 'info',
        layout: 'topRight',
        text: msg,
        timeout: 1000,
        animation: {
            open: 'animated bounceInRight', // Animate.css class names
            close: 'animated bounceOutRight' // Animate.css class names
        },
    }).show();
}

function notifySuccess(msg) {
    new Noty({
        type: 'success',
        layout: 'topRight',
        text: msg,
        timeout: 1000,
        animation: {
            open: 'animated bounceInRight', // Animate.css class names
            close: 'animated bounceOutRight' // Animate.css class names
        },
    }).show();
}

function notifyError(msg) {
    new Noty({
        type: 'error',
        layout: 'topRight',
        text: msg,
        timeout: 1000,
        animation: {
            open: 'animated bounceInRight', // Animate.css class names
            close: 'animated bounceOutRight' // Animate.css class names
        }

    }).show();
}

function notifyWarning(msg) {
    new Noty({
        type: 'warning',
        layout: 'topRight',
        text: msg,
        timeout: 1000,
        animation: {
            open: 'animated bounceInRight', // Animate.css class names
            close: 'animated bounceOutRight' // Animate.css class names
        }
    }).show();
}

function notifyAjax(response) {
    if (response.code == 1) {
        notifySuccess(response.msg);
    } else if (response.code == 0) {
        notifyWarning(response.msg);
    } else if (response.code == -1) {
        notifyError(response.msg);
    } else {
        notifyInfo(response.msg);
    }
}



