<?php 
    /**
     * Permission is hereby granted, free of charge, to any person obtaining a copy
     * of this software and associated documentation files (the "Software"), to deal
     * in the Software without restriction, including without limitation the rights
     * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     * copies of the Software, and to permit persons to whom the Software is
     * furnished to do so, subject to the following conditions:
     * 
     * The above copyright notice and this permission notice shall be included in
     * all copies or substantial portions of the Software.
     * 
     * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     * THE SOFTWARE.
    */

    /**
     * @package AttwFramework
     * @author Gabriel Jacinto <gamjj74@hotmail.com>
     * @license https://github.com/AttwFramework/AttwFramework/blob/master/LICENSE.md
     * @since AttwFramework v1.0
    */
    
	use Attw\Config\Configs;
	use Attw\HTTP\Response;

	/**
	 * Errors
	*/
	if( Configs::exists( 'ErrorsReporting' ) ){
		error_reporting( Configs::get( 'ErrorsReporting' ) );
	}else{
		error_reporting( E_ALL | E_STRICT );
	}

	/**
	 * Error logs
	*/
	if( Config::exists( 'Logs' ) ){
		$logsConfig = Config::get( 'Logs' );

		if( isset( $logsConfig['SystemErrorLogs'] ) ){
			if( isset( $logsConfig['SystemErrorLogs']['Activated'] ) && $logsConfig['SystemErrorLogs']['Activated'] ){
				if( !isset( $logsConfig['SystemErrorLogs']['File'] ) ){
					throw new RuntimeException( 'To activate the system error logs, indicate the file to save logs' );
				}
				
				ini_set( 'log_errors', true );
				ini_set( 'error_log', $logsConfig['SystemErrorLogs']['File'] );
			}
		}
	}

	/**
	 * Timezone
	*/
	if( Configs::exists( 'Timezone' ) ){
		date_default_timezone_set( Configs::get( 'Timezone' ) );
	}

	/**
	 * Page encoding
	*/
	if( Configs::exists( 'Content-Type' ) ){
		$response = new Response;
		if( Configs::exists( 'Charset' ) ){
			$response->sendHeader( 'Content-Type', Configs::get( 'Content-Type' ) . '; Charset=' . Configs::get( 'Charset' ) );
		}else{
			$response->sendHeader( 'Content-Type', Configs::get( 'Content-Type' ) );
		}
	}