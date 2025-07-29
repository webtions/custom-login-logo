jQuery(document).ready(function ($) {
	const uploadSection = $('.upload');

	if (!uploadSection.length) {
		return;
	}

	let mediaFrame;

	uploadSection.each(function () {
		const section = $(this);
		const textInput = section.find('.text-upload');
		const button = section.find('.button-upload');
		const preview = section.find('.preview-upload');

		button.on('click', function (e) {
			e.preventDefault();

			// If media frame already exists, reopen it
			if (mediaFrame) {
				mediaFrame.open();
				return;
			}

			// Create media frame
			mediaFrame = wp.media({
				title: 'Select or Upload Logo',
				button: {
					text: 'Use this image',
				},
				multiple: false,
			});

			mediaFrame.on('select', function () {
				const attachment = mediaFrame.state().get('selection').first().toJSON();
				textInput.val(attachment.url).trigger('change');
				preview.attr('src', attachment.url).show();
			});

			mediaFrame.open();
		});

		textInput.on('change', function () {
			const url = $(this).val();
			preview.attr('src', url).show();
		});
	});
});
