<div class="wrap wpsh-wrap">
	<h1>WP Shortcode Highlighter Settings</h1>
	<form name="form" action="options.php" method="post">
        <?php settings_fields( 'wp-shortcode-highlighter-options' ); ?>
        <?php do_settings_sections( 'wp-shortcode-highlighter-options' ); ?>
		<h2 class="title">
			Highlighter Style
		</h2>
        <table class="form-table wpsh-main-form">
        <tbody>
        <tr>
            <td>
        		<table class="form-table">
        			<tbody>
                       
        				<tr>
        					<th>
        						<label>
        							Background Color	
        						</label>
        					</th>
        					<td>
        						<input type="text" data-element='.wpsh-options-preview .shortcode-highlighter-container' data-style="background-color" name="wpsh_background_color" class="wpsh-color-field" value="<?php echo esc_attr( get_option('wpsh_background_color') ); ?>" />
        					</td>
        				</tr>
                        <tr>
        					<th>
        						<label>
        							Border Color	
        						</label>
        					</th>
        					<td>
        						<input type="text" data-element='.wpsh-options-preview .shortcode-highlighter-container' data-style="border-color" name="wpsh_border_color" class="wpsh-color-field" value="<?php echo esc_attr( get_option('wpsh_border_color') ); ?>" />
        					</td>
        				</tr>
                        <tr>
        					<th>
        						<label>
        							Text Color	
        						</label>
        					</th>
        					<td>
        						<input type="text" data-element='.wpsh-options-preview .shortcode-highlighter-container' data-style="color" name="wpsh_text_color" class="wpsh-color-field" value="<?php echo esc_attr( get_option('wpsh_text_color') ); ?>" />
        					</td>
        				</tr>
                        
                        <tr>
        					<th>
        						<label>
        							Parameter Color	
        						</label>
        					</th>
        					<td>
        						<input type="text" data-element='.wpsh-options-preview .shortcode-highlighter-parameter' data-style="color" name="wpsh_parameter_color" class="wpsh-color-field" value="<?php echo esc_attr( get_option('wpsh_parameter_color') ); ?>" />
        					</td>
        				</tr>
        				
        			</tbody>
        		</table>
        	</td>
            <td>
                <style>                
                .wpsh-wrap span.shortcode-highlighter-parameter {color:<?php echo esc_attr( get_option('wpsh_text_color') ); ?>;}
                .wpsh-wrap span.shortcode-highlighter-container {background-color:<?php echo esc_attr( get_option('wpsh_background_color') ); ?>; border-color:<?php echo esc_attr( get_option('wpsh_border_color') ); ?>; color:<?php echo esc_attr( get_option('wpsh_parameter_color') ); ?>;}
                </style>
				<div class="wpsh-options-preview">
                    <div class="wpsh-options-preview-shortcode">
                        <span class="shortcode-highlighter shortcode-highlighter-container">[shortcode with=<span class="shortcode-highlighter shortcode-highlighter-parameter">"parameters"</span>]</span>
                    </div>
                </div>
            </td>
        </tr>
        </tbody>
        </table>
		<?php submit_button();?>
		
	</form>
</div>