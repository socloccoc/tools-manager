/**
 * Created by daidv on 29/07/2019.
 */
lang = {
  'ERROR_EMAIL_FORMAT': 'Mail không đúng định dạng',
  'ERROR_REQUIRED': 'Không được để trống',
  'ERROR_MAX_LENGTH': 'Không được quá %s ký tự',
  'ERROR_MIN_LENGTH': 'Trường này cần tối thiểu %s',
  'ERROR_PHONE_FORMAT': 'SĐT không đúng định dạng',
  'ERROR_MAX_VALUE': 'Trường này có giá trị lớn nhất là %s',
  'ERROR_MIN_VALUE': 'Trường này có giá trị nhỏ nhất là %s',
  'ERROR_URL_FORMAT': 'URL không đúng định dạng',
  'ERROR_NUMBER_FORMAT': 'Không phải là kiểu số',
  'ERROR_GTE': 'Phải lớn hơn hoặc bằng %s',
  'ERROR_GT': 'Phải nhỏ hơn %s',
  'ERROR_LTE': 'Phải nhỏ hơn hoặc bằng %s',
  'ERROR_LT': 'Phải lớn hơn %s'
};
base = function (options) {
  return this.init(options);
};
base.prototype = {
  options: {
    forms: []
  },
  init: function (options) {
    this.mergeOptions(options);
    this.addEvent();
    return this;
  },
  addEvent: function () {
    var opt = this.options,
        cls = this;
    for (var index in opt.forms) {
      var frm = opt.forms[index];
      if (frm.validate == true && frm.$obj) {
        for(var obj in frm.$obj) {
          frm.$obj[obj].group = frm;
        }
        // add event on submit to form
        frm.$obj.on('submit', function (e) {
          if (this.group.validate == true) {
            if (cls.validateForm($(this))) {
              return true;
            } else {
              e.stopImmediatePropagation();
              return false;
            }
          }
        });
        // add event to element has required attr
        frm.$obj.on('blur', '[required]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_required($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element has maxLength attr
        frm.$obj.on('paste blur', '[maxlength]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_max_length($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element has minLength attr
        frm.$obj.on('paste blur', '[minlength]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_min_length($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element has min attr
        frm.$obj.on('paste blur', '[min]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_min($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element has max attr
        frm.$obj.on('paste blur', '[max]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_max($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is email
        frm.$obj.on('paste blur', '[type="email"]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_email($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is tel
        frm.$obj.on('paste blur', '[type="tel"]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_tel($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is date
        frm.$obj.on('paste blur', '[type="date"]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_date($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is postal code
        frm.$obj.on('paste blur', '.postal-code:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_postal_code($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is url
        frm.$obj.on('paste blur', '.field-url:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_url($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is number
        frm.$obj.on('paste blur', '.number:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_number($(this), frm.validate_ok, frm.validate_error);
        });
        // add event to element is decimal
        frm.$obj.on('paste blur', '.decimal:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_decimal($(this), frm.validate_ok, frm.validate_error);
        });

        frm.$obj.on('paste blur', '[gte]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_great_than_equal($(this), frm.validate_ok, frm.validate_error);
        });

        frm.$obj.on('paste blur', '[gt]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_great_than($(this), frm.validate_ok, frm.validate_error);
        });

        frm.$obj.on('paste blur', '[lte]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_less_than_equal($(this), frm.validate_ok, frm.validate_error);
        });

        frm.$obj.on('paste blur', '[lt]:not([disabled])', function () {
          var frm = $(this).parents('form')[0].group;
          base.validate_less_than($(this), frm.validate_ok, frm.validate_error);
        });

        frm.$obj.on('focus', 'input:not([disabled])', function() {
          var $this = $(this),
            msg = $this.parent().find('.error-message');
          if(msg.length > 0) {
            msg.slideDown();
          }
        });

        frm.$obj.on('blur', 'input:not([disabled])', function() {
          var $this = $(this),
            msg = $this.parent().find('.error-message');
          if(msg.length > 0) {
            msg.slideUp();
          }
        });
      }
    }
  },
  validateForm: function (frm) {
    var success = true;
    // add event to element has maxLength attr
    frm.find('[minlength]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_max_length($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element has minLength attr
    frm.find('[minlength]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_min_length($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element has min attr
    frm.find('[min]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_min($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element has max attr
    frm.find('[max]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_max($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element has required attr
    frm.find('[required]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_required($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is email
    frm.find('[type="email"]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_email($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is tel
    frm.find('[type="tel"]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_tel($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is date
    frm.find('[type="date"]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_date($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is postal-code
    frm.find('.postal-code:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_postal_code($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is url
    frm.find('.field-url:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_url($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is number
    frm.find('.number:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_number($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    // add event to element is decimal
    frm.find('.decimal:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_decimal($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });

    frm.find('[gte]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_great_than_equal($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });

    frm.find('[gt]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_great_than($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });

    frm.find('[lte]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_less_than_equal($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });

    frm.find('[lt]:not([disabled])').each(function (i, e) {
      var frm = $(this).parents('form')[0].group;
      if(base.validate_less_than($(e), frm.validate_ok, frm.validate_error, true) == false) {
        success = false;
      }
    });
    return success;
  },
  mergeOptions: function (options) {
    for (var option in options) {
      this.options[option] = options[option];
    }
  }
};

base.loadComplete = function (append) {
  var th = this;
  th.opt.data.data = $(this).val();
  $.ajax({
    url: th.opt.source,
    method: 'POST',
    data: th.opt.data,
    complete: function (html) {
      if (append !== undefined || html.responseJSON.collection.length === undefined) {
        var data = '<div class="au-container" data-target="#' + th.id + '">';
        var collection = {};
        if (append !== undefined && append.title.substring(0, th.opt.data.data.length) == th.opt.data.data) {
          if(html.responseJSON.collection.length === undefined) {
            collection = html.responseJSON.collection;
          }
          collection[append.value] = append.title;
          var values = Object.values(collection);
          values.sort();
          collection = Object.swap(collection);
          for (var ind in values) {
            data += '<div class="au-item" data-id="' + collection[values[ind]] + '">' + values[ind] + '</div>';
          }
        } else {
          if(html.responseJSON.collection.length === undefined) {
            collection = html.responseJSON.collection;
          }
          for (var key in collection) {
            data += '<div class="au-item" data-id="' + key + '">' + collection[key] + '</div>';
          }
        }
        data += '</div>';
        var $this = $(th);
        if ($('.au-container').length == 0) {
          $res = $(data);
          $res.insertAfter($this);
        } else {
          $res = $('.au-container');
          $res[0].outerHTML = data;
        }
        $res.parent().css({'position': 'relative'});
        $(document).on('mousedown', '.au-item',function (e) {
          //e.preventDefault();
          //e.stopPropagation();
          e.stopImmediatePropagation();
          var $t = $(this);
          var $container = $t.parent();
          var $input = $($container.attr('data-target'));
          $input.val($t.html());
          $('[name="' + $input.attr('data-id') + '"]').val($t.attr('data-id'));
        });
      } else {
        var container = $('.au-container');
        if (container.length > 0) {
          container.remove();
        }
      }
    }
  });
};

base.validate_great_than_equal = function ($obj, trigger_ok, trigger_error, post) {
  var $gte_obj = $('#' + $obj.attr('gte'));
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  $gte_obj.val(base.toASCII($gte_obj.val()));
  var param = {
    type: 'gte',
    msg: false
  };
  var val = $obj.val().trim();
  var gteval = $gte_obj.val().trim();
  if(val != '' && gteval != '' && (parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) &&
    (parseInt(gteval).toString().length == gteval.length || parseFloat(gteval).toString().length == gteval.length) && parseInt(gteval) > parseInt(val)) {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.gte');
        if (msg.length == 0) {
          var $er = $('<div class="error-message gte none">' + base.__('ERROR_GTE', gteval) + '</div>');
          $er.insertAfter($obj);
          //if (post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.gte');
      if (msg.length == 0) {
        var $er = $('<div class="error-message gte none">' + base.__('ERROR_GTE', gteval) + '</div>');
        $er.insertAfter($obj);
        //if (post != true) {
        //  $er.slideDown();
        //}
        $obj.addClass('error');
      }
    }
    return false;
  } else {
    if (trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.gte');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  }

};

base.validate_less_than_equal = function ($obj, trigger_ok, trigger_error, post) {
  var $lte_obj = $('#' + $obj.attr('lte'));
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  $lte_obj.val(base.toASCII($lte_obj.val()));
  var param = {
    type: 'lte',
    msg: false
  };
  var val = $obj.val().trim();
  var lteval = $lte_obj.val().trim();
  if(val != '' && lteval != '' && (parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) &&
    (parseInt(lteval).toString().length == lteval.length || parseFloat(lteval).toString().length == lteval.length)  && parseInt(lteval) < parseInt(val)) {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.lte');
          if (msg.length == 0) {
            var $er = $('<div class="error-message lte none">' + base.__('ERROR_LTE', lteval) + '</div>');
            $er.insertAfter($obj);
            //if (post != true) {
            //  $er.slideDown();
            //}
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.lte');
        if (msg.length == 0) {
          var $er = $('<div class="error-message lte none">' + base.__('ERROR_LTE', lteval) + '</div>');
          $er.insertAfter($obj);
          //if (post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
      return false;
    } else {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.lte');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    }

};

base.validate_great_than = function ($obj, trigger_ok, trigger_error, post) {
  var $gt_obj = $('#' + $obj.attr('gt'));
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  $gt_obj.val(base.toASCII($gt_obj.val()));
  var param = {
    type: 'gt',
    msg: false
  };
  var val = $obj.val().trim();
  var gtval = $gt_obj.val().trim();
  if(val != '' && gtval != '' && (parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) &&
    (parseInt(gtval).toString().length == gtval.length || parseFloat(gtval).toString().length == gtval.length)  && parseInt(gtval) >= parseInt(val)) {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.gt');
          if (msg.length == 0) {
            var $er = $('<div class="error-message gt none">' + base.__('ERROR_GT', gtval) + '</div>');
            $er.insertAfter($obj);
            //if (post != true) {
            //  $er.slideDown();
            //}
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.gt');
        if (msg.length == 0) {
          var $er = $('<div class="error-message gt none">' + base.__('ERROR_GT', gtval) + '</div>');
          $er.insertAfter($obj);
          //if (post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
      return false;
    } else {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.gt');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    }
};

base.validate_less_than = function ($obj, trigger_ok, trigger_error, post) {
  var $lt_obj = $('#' + $obj.attr('lt'));
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  $lt_obj.val(base.toASCII($lt_obj.val()));
  var param = {
    type: 'lt',
    msg: false
  };
  var val = $obj.val().trim();
  var ltval = $lt_obj.val().trim();
  if(val != '' && ltval != '' && (parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) &&
    (parseInt(ltval).toString().length == ltval.length || parseFloat(ltval).toString().length == ltval.length)  && parseInt(ltval) >= parseInt(val)) {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.lt');
          if (msg.length == 0) {
            var $er = $('<div class="error-message lt none">' + base.__('ERROR_LT', ltval) + '</div>');
            $er.insertAfter($obj);
            //if (post != true) {
            //  $er.slideDown();
            //}
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.lt');
        if (msg.length == 0) {
          var $er = $('<div class="error-message lt none">' + base.__('ERROR_LT', ltval) + '</div>');
          $er.insertAfter($obj);
          //if (post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
      return false;
    } else {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.lt');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    }
};

base.validate_max_length = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'maxlength',
    msg: false
  };
  if ($obj.attr('maxlength') >= $obj.val().length) {
    if (trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.maxlength');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.maxlength');
        if (msg.length == 0) {
          var $er = $('<div class="error-message maxlength none">' + base.__('ERROR_MAX_LENGTH', $obj.attr('maxlength')) + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.maxlength');
      if (msg.length == 0) {
        var $er = $('<div class="error-message maxlength none">' + base.__('ERROR_MAX_LENGTH', $obj.attr('maxlength')) + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_min_length = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'minlength',
    msg: false
  };
  var val = $obj.val().trim();
  if (val == '' || (val != '' && $obj.attr('minlength') <= val.length)) {
    if (trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.minlength');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp('minlength');
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.minlength');
        if (msg.length == 0) {
          var $er = $('<div class="error-message minlength none">' + base.__('ERROR_MIN_LENGTH', $obj.attr('minlength')) + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.minlength');
      if (msg.length == 0) {
        var $er = $('<div class="error-message minlength none">' + base.__('ERROR_MIN_LENGTH', $obj.attr('minlength')) + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_max = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'max',
    msg: false
  };
  var val = $obj.val().trim();
  if(parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) {
    if (parseInt($obj.attr('max')) >= parseInt(val)) {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.max');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.max');
          if (msg.length == 0) {
            var $er = $('<div class="error-message max none">' + base.__('ERROR_MAX_VALUE', $obj.attr('max')) + '</div>');
            $er.insertAfter($obj);
            //if(post != true) {
            //  $er.slideDown();
            //}
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.max');
        if (msg.length == 0) {
          var $er = $('<div class="error-message max none">' + base.__('ERROR_MAX_VALUE', $obj.attr('max')) + '</div>');
          $er.insertAfter($obj);
          //if(post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
      return false;
    }
  }
};

base.validate_min = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'min',
    msg: false
  };
  var val = $obj.val().trim();
  if(parseInt(val).toString().length == val.length || parseFloat(val).toString().length == val.length) {
    if (parseInt($obj.attr('min')) <= parseInt($obj.val()) || $obj.parent().find('.error-message.required').length > 0) {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.min');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.min');
          if (msg.length == 0) {
            var $er = $('<div class="error-message min none">' + base.__('ERROR_MIN_VALUE', $obj.attr('min')) + '</div>');
            $er.insertAfter($obj);
            //if(post != true) {
            //  $er.slideDown();
            //}
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.min');
        if (msg.length == 0) {
          var $er = $('<div class="error-message min none">' + base.__('ERROR_MIN_VALUE', $obj.attr('min')) + '</div>');
          $er.insertAfter($obj);
          //if(post != true) {
          //  $er.slideDown();
          //}
          $obj.addClass('error');
        }
      }
      return false;
    }
  }
};

base.validate_number = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'number',
    msg: false
  };
  var val = $obj.val().trim();
  if(val == '' || (val != '' && parseInt(val).toString().length == val.length)) { //is_int
    if(trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.number');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.number');
        if (msg.length == 0) {
          var $er = $('<div class="error-message number none">' + base.__('ERROR_NUMBER_FORMAT') + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.number');
      if (msg.length == 0) {
        var $er = $('<div class="error-message number none">' + base.__('ERROR_NUMBER_FORMAT') + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_decimal = function ($obj, trigger_ok, trigger_error, post) {
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'decimal',
    msg: false
  };
  var val = $obj.val().trim();
  if(val == '' || (val != '' && parseFloat(val).toString().length == val.length)) {
    if(trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.decimal');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.decimal');
        if (msg.length == 0) {
          var $er = $('<div class="error-message decimal none">' + base.__('ERROR_DECIMAL_FORMAT') + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.decimal');
      if (msg.length == 0) {
        var $er = $('<div class="error-message decimal none">' + base.__('ERROR_DECIMAL_FORMAT') + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_email = function($obj, trigger_ok, trigger_error, post){
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'email',
    msg: false
  };
  var regex = /^([-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?)?$/i;
  var val = $obj.val().trim();
  if(val === '' || (val != '' && regex.test(val))) {
      if(trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.email');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.email');
          if (msg.length == 0) {
            var $er = $('<div class="error-message email none">' + base.__('ERROR_EMAIL_FORMAT') + '</div>');
            $er.insertAfter($obj);
            if(post != true) {
              $er.slideDown();
            }
            $obj.addClass('error');
          }
        }
      } else {
        var $er = $('<div class="error-message email none">' + base.__('ERROR_EMAIL_FORMAT') + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
      return false;
    }
};

base.validate_tel = function($obj, trigger_ok, trigger_error, post){
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'tel',
    msg: false
  };
  var line_regex1 = /^0{1}(((([0-9]{1}-[0-9]{4})|([0-9]{2}-([0-9]{3}|[0-9]{4})))-[0-9]{4}$)|([0-9]{9}$))/;
  var val = $obj.val().trim();
  if (val === '' || (val !== '' && line_regex1.test(val))) {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.tel');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
      return true;
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.tel');
          if (msg.length == 0) {
            var $er = $('<div class="error-message tel none">' + base.__('ERROR_PHONE_FORMAT') + '</div>');
            $er.insertAfter($obj);
            if(post != true) {
              $er.slideDown();
            }
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.tel');
        if (msg.length == 0) {
          var $er = $('<div class="error-message tel none">' + base.__('ERROR_PHONE_FORMAT') + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
      return false;
    }
};

base.validate_required = function ($obj, trigger_ok, trigger_error, post) {
  var param = {
    type: 'required',
    msg: false
  };
  if($obj.val().trim() !== '') {
    if(trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.required');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.required');
        if (msg.length == 0) {
          var $er = $('<div class="error-message required none">' + base.__('ERROR_REQUIRED') + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.required');
      if (msg.length == 0) {
        var $er = $('<div class="error-message required none">' + base.__('ERROR_REQUIRED') + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_date = function ($obj, trigger_ok, trigger_error, post) {
  if ($obj.val() != '') {
    var valid = true;
    // STRING FORMAT yyyy-mm-dd
    if ($obj.val() == "" || $obj.val() == null) {
      valid = false;
    }

    // m[1] is year 'YYYY' * m[2] is month 'MM' * m[3] is day 'DD'
    var m = $obj.val().match(/(\d{4})-(\d{2})-(\d{2})/);

    // STR IS NOT FIT m IS NOT OBJECT
    if (m === null || typeof m !== 'object') {
      valid = false;
    }

    // CHECK m TYPE
    if (typeof m !== 'object' && m !== null && m.size !== 3) {
      valid = false;
    }

    var maxYear = 2050; //YEAR NOW
    var minYear = 1900; //MIN YEAR

    // YEAR CHECK
    if ((m[1].length < 4) || m[1] < minYear || m[1] > maxYear) {
      valid = false;
    }
    // MONTH CHECK
    if ((m[2].length < 2) || m[2] < 1 || m[2] > 12) {
      valid = false;
    }
    // DAY CHECK
    if ((m[3].length < 2) || m[3] < 1 || m[3] > 31) {
      valid = false;
    }

    if (valid == true) {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp();
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.format');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp('date');
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.format');
        if (msg.length == 0) {
          $('<div class="error-message format"></div>').insertAfter($obj);
          $obj.addClass('error');
        }
      }
    }
  }
};

base.validate_postal_code = function($obj, trigger_ok, trigger_error, post){
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'postal_code',
    msg: false
  };
  var postal_code_regex1 = /^[0-9]{3}-[0-9]{4}$|^[0-9]{7}$/;
  var postal_code_regex2 = /^¥d{3}-¥d{4}$|^¥d{3}-¥d{2}$|^¥d{3}$/;
  var val = $obj.val().trim();
  if (val === '' || (val !== '' && postal_code_regex1.test(val))) {
    if (trigger_ok) {
      $obj.tmp = trigger_ok;
      $obj.tmp(param);
      $obj.tmp = undefined;
    } else {
      var msg = $obj.parent().find('.error-message.postal_code');
      if (msg.length > 0) {
        msg.remove();
        $obj.removeClass('error');
      }
    }
    return true;
  } else {
    if (trigger_error) {
      $obj.tmp = trigger_error;
      $obj.tmp(param);
      $obj.tmp = undefined;
      if (param.msg === true) {
        var msg = $obj.parent().find('.error-message.postal_code');
        if (msg.length == 0) {
          var $er = $('<div class="error-message postal_code none">' + base.__('ERROR_POSTAL_CODE_FORMAT') + '</div>');
          $er.insertAfter($obj);
          if(post != true) {
            $er.slideDown();
          }
          $obj.addClass('error');
        }
      }
    } else {
      var msg = $obj.parent().find('.error-message.postal_code');
      if (msg.length == 0) {
        var $er = $('<div class="error-message postal_code none">' + base.__('ERROR_POSTAL_CODE_FORMAT') + '</div>');
        $er.insertAfter($obj);
        if(post != true) {
          $er.slideDown();
        }
        $obj.addClass('error');
      }
    }
    return false;
  }
};

base.validate_url = function($obj, trigger_ok, trigger_error, post){
  //convert fullwidth to halfwidth
  $obj.val(base.toASCII($obj.val()));
  var param = {
    type: 'url',
    msg: false
  };
  var pattern = new RegExp('^((https|http):\/\/){1,}' + // protocol
    '((([a-z\d]([a-z\d-]*[a-z\d])*)\.)+[a-z]{2,}|' + // domain name
    '((\d{1,3}\.){3}\d{1,3}))' + // OR ip (v4) address
    '(\:\d+)?(\/[-a-z\d%_.~+]*)*'); //+ // port and path
  //'(\?[;&a-z\d%_.~+=-]*)?'+ // query string
  //'(\#[-a-z\d_]*)?$','i' fragment locater
  var val = $obj.val().trim();
  if (val === '' || (val !== '' && pattern.test(val))) {
      if (trigger_ok) {
        $obj.tmp = trigger_ok;
        $obj.tmp(param);
        $obj.tmp = undefined;
      } else {
        var msg = $obj.parent().find('.error-message.url');
        if (msg.length > 0) {
          msg.remove();
          $obj.removeClass('error');
        }
      }
    return true;
    } else {
      if (trigger_error) {
        $obj.tmp = trigger_error;
        $obj.tmp(param);
        $obj.tmp = undefined;
        if (param.msg === true) {
          var msg = $obj.parent().find('.error-message.url');
          if (msg.length == 0) {
            var $er = $('<div class="error-message url none">' + base.__('ERROR_URL_FORMAT') + '</div>');
            $er.insertAfter($obj);
            if(post != true) {
              $er.slideDown();
            }
            $obj.addClass('error');
          }
        }
      } else {
        var msg = $obj.parent().find('.error-message.url');
        if (msg.length == 0) {
          var msg = $obj.parent().find('.error-message.url');
          if (msg.length == 0) {
            var $er = $('<div class="error-message url none">' + base.__('ERROR_URL_FORMAT') + '</div>');
            $er.insertAfter($obj);
            if(post != true) {
              $er.slideDown();
            }
            $obj.addClass('error');
          }
        }
      }
    return false;
    }
};

base.serialize = function ($obj, formdata) {
  $el = $obj.find('input[type="text"], input[type="tel"], input[type="number"], input[type="email"], input[type="date"], input[type="password"], input[type="hidden"]');
  if (formdata) {
    var ret = new FormData();
    for (var i = 0; i < $el.length; i++) {
      ret.append($el[i].name.trim(), $el[i].value.trim());
    }
    $el = $obj.find('input[type="file"]');
    //var ind = {};
    for (var i = 0; i < $el.length; i++) {
      if($el[i].files[0] !== undefined) {
        ret.append($el[i].name, $el[i].files[0]);
      }
      //if($el[i].name.indexOf('[]')) {
      //if(ind[$el[i].name]) {
      //  data.append($el[i].name, $el[i].files);
      //ind[$el[i].name] = ind[$el[i].name] + 1;
      //} else {

      //ind[$el[i].name] = 0;
      //}
      //}
    }
    $el = $obj.find('input[type="checkbox"]');
    for (var i = 0; i < $el.length; i++) {
      if ($($el[i]).prop('checked') === true) {
        ret.append($el[i].name.trim(), $el[i].value.trim());
      }
    }
    $el = $obj.find('input[type="radio"]:checked');
    for (var i = 0; i < $el.length; i++) {
      ret.append($el[i].name.trim(), $($el[i]).val().trim());
    }
    $el = $obj.find('textarea');
    for (var i = 0; i < $el.length; i++) {
      ret.append($el[i].name.trim(), $($el[i]).val().trim());
    }
    $el = $obj.find('select');
    for (var i = 0; i < $el.length; i++) {
      ret.append($el[i].name.trim(), $($el[i]).val().trim());
    }
  } else {
    var ret = {};
    for (var i = 0; i < $el.length; i++) {
      ret[$el[i].name.trim()] = $el[i].value.trim();
    }
    $el = $obj.find('input[type="checkbox"]');
    for (var i = 0; i < $el.length; i++) {
      if ($($el[i]).prop('checked') === true) {
        ret[$el[i].name.trim()] = $el[i].value.trim();
      }
    }
    $el = $obj.find('input[type="radio"]:checked');
    for (var i = 0; i < $el.length; i++) {
      ret[$el[i].name.trim()] = $($el[i]).val().trim();
    }
    $el = $obj.find('textarea');
    for (var i = 0; i < $el.length; i++) {
      ret[$el[i].name.trim()] = $($el[i]).val().trim();
    }
    $el = $obj.find('select');
    for (var i = 0; i < $el.length; i++) {
      ret[$el[i].name.trim()] = $($el[i]).val().trim();
    }
  }
  return ret;
};

base.submit = function (target) {
  var $target = $(target),
          $form = $target.parents('form');
  if ($form.length > 0) {
    var $currentp = parseInt($form.find('.page.active').html()),
            $pcount = $form.find('.page-counter');
    if ($pcount.length > 0) {
      var pcounter = parseInt($pcount[0].value);
      if ($target.hasClass('page') && !$target.hasClass('active')) {
        $currentp = parseInt($target.html());
      } else if ($target.hasClass('first-page')) {
        $currentp = 1;
      } else if ($target.hasClass('last-page')) {
        $currentp = pcounter;
      } else if ($target.hasClass('prev-page')) {
        $currentp -= 1;
      } else if ($target.hasClass('nxt-page')) {
        $currentp += 1;
      }
      $form.append('<input type="hidden" name="page" value="' + $currentp + '" />');
      $form.submit();
    }
  }
};

base.errors = function ($form, errors) {
  if(!$form) return;
  var error_message = $form.find('.error-message');
  if (errors == '' && error_message.length > 0) {
    error_message.remove();
    $form.find('.error').removeClass('error');
  } else {
    for (var obj in errors) {
      var field = $form.find('[name="' + obj + '"]');
      field.addClass('error');
      var fieldc = field.parent();
      fieldc.find('.error-message').remove();
      for (var type in errors[obj]) {
        fieldc.append('<div class="error-message ' + type + ' none">' + errors[obj][type] + '</div>');
      }
    }
  }
};

base.message = function ($message, $error) {
  var message = $('<div class="message-float ' + ($error == true ? 'error' : '') + '" style="top: -100px">' + $message + '</div>');
  $('body').append(message);
  var top = -100;
  var interval = setInterval(function(){
    if(top >= 50) {
      clearInterval(interval);
      var wait = setTimeout(function(){
        message.fadeOut(100);
      }, 2000);
    }
    message.css('top', top + 'px');
    top += 10;
  },30);
};

base.toASCII = function (chars) {
  var ascii = '';
  for(var i=0, l = chars.length; i < l; i++) {
    var c = chars[i].charCodeAt(0);

    // make sure we only convert half-full width char
    if (c >= 0xFF00 && c <= 0xFFEF) {
      c = 0xFF & (c + 0x20);
    }

    ascii += String.fromCharCode(c);
  }

  return ascii;
};

base.__ = function () {
  if (lang) {
    if (arguments.length > 0 && lang[arguments[0]]) {
      var tmp = lang[arguments[0]];
      for(var index in arguments) {
        if(index > 0) {
          if(tmp.indexOf('%s') != -1) {
            tmp = tmp.replace('%s', arguments[index]);
          }
        }
      }
      return tmp;
    } else {
      if (dbg === true) {
        alert('Not valid lang for ' + arguments[0]);
      } else {
        if(arguments.length > 0) {
          return arguments[0];
        } else {
          return '';
        }
      }
    }
  } else {
    if (dbg === true) {
      alert('Not valid variable lang');
    } else {
      if(arguments.length > 0) {
        return arguments[0];
      } else {
        return '';
      }
    }
  }
};

/*
 * Object.value support for IE & Chrome
 * Firefox native support this function
 */
  Object.values = function (obj) {
    var ret = [], ind = 0;
    for (var key in obj) {
      if (typeof obj[key] == 'string') {
        ret[ind] = obj[key];
        ind++;
      }
    }
    return ret;
  };

/*
 * Swap key and value of object
 */
  Object.swap = function(obj){
    var ret = {};
    for(var key in obj){
      ret[obj[key]] = key;
    }
    return ret;
  };

/*
 * Loader
 * To show $(obj).loader()
 * To hide $(obj).loader('hide')
 */
$.fn.loading = function(hide){
  hide = hide == undefined ? false : hide;
  if(hide == false) {
    this.append('<div class="overlay"><div class="spin-vert"><div class="spin-hor"><div class="spin"><i class="fa fa-spinner fa-spin"></i> Loading</div></div></div></div>');
    this.css('position', 'relative');
  } else {
    this.css('position', '');
    this.find('.overlay').remove();
  }
};
var dbg = true;
