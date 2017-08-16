<?php

$FORMS = Array();

$FORMS['swf_file'] = $FORMS['img_file'] = <<<END
%system makeThumbNailFull('%filepath%', '570', '300', 'clear', '0', '0', '5', '0', '100')%
END;

$FORMS['relation_mul_block'] = <<<END

				<div class="videos">
					<div class="container">
						<div class="row">
							<div class="col-xs-24">
								<div class="videos-list">%items%
								</div>
							</div>
						</div>
					</div>
				</div>
END;

$FORMS['relation_mul_item'] = <<<END

									<div class="video-item">
										<span class="name">%value%</span>
										<a href="#modal-video" data-toggle="modal" data-src="%data getPropertyOfObject(%object_id%, 'link', 'clear')%" data-title="%value%">
											<img class="img-responsive" src="%data getPropertyOfObject(%object_id%, 'image', 'videos')%" alt="%value%" />
										</a>
									</div>
END;

?>