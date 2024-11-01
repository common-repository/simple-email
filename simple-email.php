<?php
/*
Plugin Name: Simple Email
Version: 0.1
Plugin URI: http://thefuturewithjetpacks.com
Description: Reconfigures the wp_mail() function to use Amazon's Simple Email Service
Author: James West
Author URI: http://thefuturewithjetpacks.com
*/

/**
* @author James West
* @copyright James West, 2011, All Rights Reserved
*
* Redistribution and use in source and binary forms, with or without
* modification, are permitted provided that the following conditions are met:
*
* - Redistributions of source code must retain the above copyright notice,
*   this list of conditions and the following disclaimer.
* - Redistributions in binary form must reproduce the above copyright
*   notice, this list of conditions and the following disclaimer in the
*   documentation and/or other materials provided with the distribution.
*
* THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
* AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
* IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
* ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
* LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
* CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
* SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
* INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
* CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
* ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
* POSSIBILITY OF SUCH DAMAGE.
*
* This is a modified BSD license (the third clause has been removed).
* The BSD license may be found here:
* http://www.opensource.org/licenses/bsd-license.php
**/

define( 'AWS_API_KEY', 'your api key' );
define( 'AWS_SECRET', 'your aws secret' );
define( 'FROM_EMAIL', 'a previously validated email' );

add_action( 'phpmailer_init', 'phpmailer_init_aws' );
function phpmailer_init_aws( $phpmailer ) {
    require_once 'lib/ses.php';

    $ses = new SimpleEmailService( AWS_API_KEY, AWS_SECRET );
    
    $message = new SimpleEmailServiceMessage();
    
    foreach ( $phpmailer->to[0] as $recipient ) {
	if ( $recipient != '') 
		$message->addTo( trim( $recipient ) );
    } 

    if ( is_array( $phpmailer->cc ) )
    	$message->addCC( $phpmailer->cc );

    if ( is_array( $phpmailer->bcc ) )
    	$message->addBCC( $phpmailer->bcc );

    if ( is_array( $phpmailer->ReplyTo ) )
    	$message->addReplyTo( $phpmailer->ReplyTo );
    
    $message->setFrom( FROM_EMAIL );
    $message->setSubject( $phpmailer->Subject );
    $message->setSubjectCharset( $phpmailer->CharSet );
    $message->setMessageCharset( $phpmailer->CharSet );
    
    if ( $phpmailer->ContentType == 'text/html' ) {
        $message->messagehtml = $phpmailer->Body;
    }
    else {
        $message->messagetext = $phpmailer->Body;
    }
    
    $ses->message = $message;
    $phpmailer = $ses;
}
