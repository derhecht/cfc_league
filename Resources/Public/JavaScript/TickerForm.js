define([ 'jquery' ], function(jQuery) {
	var TickerForm = {
		previewField : null,

		init: function(info) {
			this.ticker();
			window.TickerForm = this;
			console.info({hello2: info});
		},

		pause: function () {
			var form = document.forms[0];
			var now = (new Date()).getTime();
			form.watch_localtime.value = now;
			setTimeout(function() {
				TickerForm.pause()
			}, 1000);
		},
	    toTime: function(tstamp) {
	    	return new Date(tstamp).toLocaleString() + " (" + tstamp +")";
	    },
		ticker: function() {
			var form = document.forms[0];
			var now = (new Date()).getTime();
			form.watch_localtime.value = now;
	
			var paused = parseInt(form.watch_pausetime.value);
			var start = parseInt(form.watch_starttime.value);
			if(start > 0) {
				offset = this.trim(form.watch_offset.value);
				offset = parseInt(isNaN(offset) || offset == "" ? 0 : offset);
				diff = new Date((paused > 0 ? paused : now) - start);
				std = diff.getHours();
				min = diff.getMinutes() + ((std - 1) * 60) + offset;
				sec = diff.getSeconds();
				form.watch_minute.value = min + 1;
				form.watch.value = ((min>9) ? min : "0" + min) + ":" + ((sec>9) ? sec : "0" + sec);
			}
			if (paused == 0) {
				setTimeout(function() {
					TickerForm.ticker();
				}, 1000);
			}
			else {
				setTimeout(function() {
					TickerForm.pause()
				}, 1000);
			}
		},
		trim: function(str) {
			return str ? str.replace(/\s+/,"") : "";
		},
		
        setMatchMinute: function(elem) {
            var form = elem.form;
            min = form.watch_minute.value;
            if(min == 0) {
				return;
			}
            line = elem.name.match(/NEW(\d+)/)[1];
            var elements = jQuery(elem.form).find(":input");
            for (var i = 0; i < elements.length; i++) {

                if(elements[i].name == "data[tx_cfcleague_match_notes][NEW"+line+"][minute]") {

                    if(jQuery(elements[i]).val() == '') {
                        jQuery(elements[i]).val(min);
                        jQuery(elem.form).find("[data-formengine-input-name=\'"+elements[i].name+"\']").val(min);
                    }
                }
            }
        }

	};

	return TickerForm;
});
