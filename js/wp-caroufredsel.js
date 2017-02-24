jQuery(function($) {
    $('#foo2').carouFredSel({
        prev: '#prev2',
        next: '#next2',
        items: 3,
		auto: {
        timeoutDuration: 5000,
        delay: 5,
        items: 3
    }

    });
});