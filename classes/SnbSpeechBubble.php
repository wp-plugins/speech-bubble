<?php
/**
 * Snb Speech bubble
 */
class SnbSpeechBubble {

	private $sb_reg_type     = array( 'std', 'fb', 'fb-flat', 'ln', 'ln-flat', 'pink', 'rtail', 'drop', 'think' );
	private $sb_reg_subtype  = array( 'a', 'b', 'c', 'd' );
	private $sb_asc_subtype  = array( 
		'L1' => 'a', 
		'R1' => 'b', 
		'L2' => 'c', 
		'R2' => 'd', 
		'a'  => 'a', 
		'b'  => 'b', 
		'c'  => 'c', 
		'd'  => 'd',
		'left1'  =>'a',
		'right1' =>'b',
		'left2'  =>'c',
		'right2' =>'d'
	);
	private $sb_reg_icon_ext = array( 'jpg', 'png', 'gif', 'svg', 'tif' );
	
	
	/**
	 * Speech Bubble folder const
	 * @see shortcode_speech_bubble(), shortcode_speech_bubble_id()
	 */
	 
	const PLUGIN_FOLDER_PATH     = 'speech-bubble/';
	const PLUGIN_FOLDER_PATH_CSS = 'speech-bubble/css/';
	const PLUGIN_FOLDER_PATH_IMG = 'speech-bubble/img/';
	

	/**
	 * alert message const
	 * @see check_sb_type(), check_sb_subtype(), check_icon_extension_exists()
	 * @see get_sb_arguments_type(), get_sb_arguments_subtype(), get_sb_arguments_icon(), check_icon_reg_extension_exists()
	 */
	const SB_ALERT_SBID_INCLUDE_WHITESPACE = 'SB_ALERT_SBID_INCLUDE_WHITESPACE';
	
	const SB_ALERT_TYPE_MISSING           = 'SB_ALERT_TYPE_MISSING';
	const SB_ALERT_SUBTYPE_MISSING        = 'SB_ALERT_SUBTYPE_MISSING';
	const SB_ALERT_ICON_EXTENSION_MISSING = 'SB_ALERT_ICON_EXTENSION_MISSING';
	const SB_ALERT_DELIMITER_MISSING      = 'SB_ALERT_DELIMITER_MISSING';
		
	/**
	 * constructor
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'action_wp_enqueue_scripts' ) );
		
		add_shortcode( 'speech_bubble',       array($this, 'shortcode_speech_bubble' ) );
		add_shortcode( 'speech_bubble_preset', array($this, 'shortcode_speech_bubble_preset' ) );
		add_shortcode( 'speech_bubble_id',    array($this, 'shortcode_speech_bubble_id' ) );
	}
	
	
	/**
	 * action wp_enqueue_scripts
	 */
	public function action_wp_enqueue_scripts() {
		wp_register_style( 'sb-type-std',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS .  'sb-type-std.css' ) );
		wp_enqueue_style( 'sb-type-std' );
		wp_register_style( 'sb-type-fb',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS .  'sb-type-fb.css' ) );
		wp_enqueue_style( 'sb-type-fb' );
		wp_register_style( 'sb-type-fb-flat',	plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-fb-flat.css' ) );
		wp_enqueue_style( 'sb-type-fb-flat' );
		wp_register_style( 'sb-type-ln',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-ln.css' ) );
		wp_enqueue_style( 'sb-type-ln' );
		wp_register_style( 'sb-type-ln-flat',	plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-ln-flat.css' ) );
		wp_enqueue_style( 'sb-type-ln-flat' );
		wp_register_style( 'sb-type-pink',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-pink.css' ) );
		wp_enqueue_style( 'sb-type-pink' );
		wp_register_style( 'sb-type-rtail',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-rtail.css' ) );
		wp_enqueue_style( 'sb-type-rtail' );
		wp_register_style( 'sb-type-drop',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-drop.css' ) );
		wp_enqueue_style( 'sb-type-drop' );
		wp_register_style( 'sb-type-think',		plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-type-think.css' ) );
		wp_enqueue_style( 'sb-type-think' );
		
		wp_register_style( 'sb-no-br',			plugins_url( self::PLUGIN_FOLDER_PATH_CSS . 'sb-no-br.css' ) );
		wp_enqueue_style( 'sb-no-br' );
	}
	
	/**
	*  Shortcode [speech_bubble][/] call this function
	* 
	* @param string shortcode's argument ( type, subtype, icon ,name )
	* @param string content (saying)
	* @return string speech bubble divs
	*/
	public function shortcode_speech_bubble( $atts, $content = '' ) {
		$content = (string) $content;
		if ( 0 == strlen( $content ) ) {
			return '';
		}

		$default_atts = array(
			'type'    => 'std', 
			'subtype' => 'L1', 
			'icon'    => '1.jpg',
			'name'    => 'no name'
		);
		$atts = shortcode_atts( $default_atts, $atts );
		
		self::make_speech_bubble_divs( $code );

		$sb_type 	= self::check_sb_type( $atts['type'] );
		$sb_subtype = self::check_sb_subtype( $atts['subtype'] );
		$user_icon  = self::check_icon_extension_exists( $atts['icon'] );
		$sb_name 	= $atts['name'];

		$sb_icon_path = plugins_url( self::PLUGIN_FOLDER_PATH_IMG . $user_icon );
		
		return sprintf( $code, $sb_type, $sb_subtype, $sb_icon_path, $sb_name, $content );
	}

	/**
	*  Make the structured divs
	* 
	* @param string &$div_code structured divs
	*/
	public function make_speech_bubble_divs( &$div_code ) {
		$div_code = <<<EOD
<div class="sb-type-%s">
	<div class="sb-subtype-%s">
		<div class="sb-speaker">
			<div class="sb-icon">
				<img src="%s" class="sb-icon">
			</div>
			<div class="sb-name">%s</div>
		</div>
		<div class="sb-content">
			<div class="sb-speech-bubble">%s</div>
		</div>
	</div>
</div>
EOD;
		return;
	}
	
	
	
	/**
	*  Check whether a user's setting speech bubble type is in registered types.
	* 
	* @param string $check_arguments
	* @return string type name or ALERT MESSAGE
	*/
	function check_sb_type( $check_arguments ) { 
		$match_type = preg_replace( '/(\s|　)/', '', $check_arguments );
		$match_type = str_replace( array( '\r\n' , '\n' , '\r' ), '', $match_type );
			
		//typeが存在するかを確認して，存在しなければtype_missingを入力
		if( FALSE === in_array( $match_type, $this->sb_reg_type ) ) {
			$match_type = self::SB_ALERT_TYPE_MISSING;
		}
		
		return $match_type;
	}

	/**
	*  Check whether a user's setting speech bubble subtype is in registered subtypes.
	* 
	* @param string $check_arguments
	* @return string subtype name or ALERT MESSAGE
	*/
	function check_sb_subtype( $check_arguments ) { 
		$match_subtype = preg_replace( '/(\s|　)/', '' , $check_arguments );
		$match_subtype = str_replace( array( '\r\n', '\n', '\r'), '', $match_subtype );
			
			$check_res = array_key_exists( $match_subtype, $this->sb_asc_subtype );
			
			//subtypeが存在するかを確認して，存在しなければsubtype_missingを入力
			if( TRUE === $check_res ) {
				$match_subtype = $this->sb_asc_subtype[ $match_subtype ];
			} elseif ( FALSE === $check_res ) {
				$match_subtype = SB_ALERT_SUBTYPE_MISSING;
			}			
		return $match_subtype;
	}	

	
	/**
	*  Check whether a user's setting icon name has extion.
	* 
	* @param string $icon_file
	* @return string icon file name or ALERT MESSAGE
	*/
	function check_icon_extension_exists( $icon_file ) {
		$pos_ext  = strrpos( $icon_file, '.' );
		$len_file = strlen( $icon_file );
		
		if( $len_file - 4 == $pos_ext ) {
			//拡張子ありの場合,そのまま出力
			return $icon_file;		
		} else {
			return self::SB_ALERT_ICON_EXTENSION_MISSING;
		}
	}	



	/**
	*  Shortcode [speech_bubble_preset][/] call this function
	* 
	* @param string shortcode's argument ( type, subtype, icon ,name )
	* @param string content (saying)
	*/
	public function shortcode_speech_bubble_preset( $atts, $content = '' ) {
		$content = (string) $content;
		if ( 0 == strlen( $content ) ) {
			return '';
		}

		$default_atts = array( 'id_analysis' => 'off' );
		$atts = shortcode_atts( $default_atts, $atts );
		
		//idの解析をするかどうかの引数
		$sb_id_analysis = $atts['id_analysis'];
		
		$b_use_analysis = FALSE;
		if( 0 == strcasecmp( $sb_id_analysis, 'on' ) ) {
			$b_use_analysis = TRUE;
		}
		
		//delimiterで内容とIDsetsを分割する
		$my_delimiter = '{SPEECH_BUBBLE_DELIMITER}';
		$idsets_and_post = explode( $my_delimiter, $content );
		
		//delimiterが$contentにない場合
		if ( strcmp( $content, $idsets_and_post[0] ) == 0 ) {
		
			if( FALSE === $b_use_analysis ) {
				//中身のみ表示
				echo $content;
				return;
			} elseif ( TRUE === $b_use_analysis ) {
				//エラー解析結果を表示
				echo self::SB_ALERT_DELIMITER_MISSING;
				return;
			}
		}
		
		//delimiterがあり，$contentがid_sets部分と記事($my_post)部分に分割。
		$idsets  = $idsets_and_post[0];
		$my_post = $idsets_and_post[1];
				
		//デフォルトの引数タイプを作成
		self::make_default_arg_array( $id_arg_array );
		
		//$id_setsからショートコード用の引数$id_arg_arrayを取り出す
		$is_invalid_idsets = self::make_array_from_idsets( $idsets, $id_arg_array );
		
		
		//無効なショートコード用引数なので$my_post部分のみを書き出して，終了
		if ( FALSE === $is_invalid_idsets ) {
			echo $my_post;
			return ;		
		}
		
		//idを解析した内容を出力する 'id_analysis' => 'on'のとき
		if( TRUE === $b_use_analysis ) {
			$res = '---SPEECH_BUBBLE_ID_ANALYSIS_START---<br>';
			foreach ( $id_arg_array as $key => $value ) {
 				 $res .=  $key . '<br>' . '   =>' . $value . '<br>';
			}
			$res .= '---SPEECH_BUBBLE_ID_ANALYSIS_END---<br>';
			echo $res;
			return;
		}
		
		//$id_arg_arrayを降順にする
		krsort( $id_arg_array );
		
	    //$id_arg_arrayから$id_arrayを作成する
	    foreach( $id_arg_array as $key => $value ) {
			$id_array[] = $key;
		}
		
	    //$id_arg_arrayがポスト部分に存在するかを確認し,
		//post部分にあるid=XXX部分をすべて,id_arg_arrayに置換する
		$rep_count_total = 0;
		foreach( $id_array as $key => $value ) {
			$my_post = str_replace( $value, $id_arg_array[ $value ], $my_post, $rep_count_tmp );
			$rep_count_total += $rep_count_tmp;
		}
				
		//置換が0なら，$my_post部分のみを書き出して，終了
		if( 0 == $rep_count_total ) {
			echo $my_post;
			return ;		
		}		
		
		//置換された部分をショートコードを通して出力
		$my_post = do_shortcode( $my_post );
		echo $my_post;
		return;
		
	}
	
	/**
	*  Make default arg_array
	* 
	* @param array arg_array[IN/OUT] 
	*/
	function make_default_arg_array( &$arg_array ) {
		$arg_array = array(
			'sb_id=0001' => 'type="std" subtype="a" icon="1.jpg" name="A san"',
			'sb_id=0002' => 'type="std" subtype="b" icon="2.jpg" name="B san"',
		);	
		return;
	}
	
	
	/**
	*  Shortcode [speech_bubble_id][/] call this function
	* 
	* @param shortcode's argument ( type, subtype, icon ,name )
	* @param content (saying)
	* @return speech bubble divs
	*/
	public function shortcode_speech_bubble_id( $atts, $content = '' ) {
		$content = (string) $content;
		if ( 0 == strlen( $content ) ) {
			return '';
		}
        
		$default_atts = array(
			'type'    => 'std', 
			'subtype' => 'L1', 
			'icon'    => '1.jpg',
			'name'    => 'no name'
		);
		$atts = shortcode_atts( $default_atts, $atts );
		
		self::make_speech_bubble_divs( $code );

		$speaker_icon_path = plugins_url( self::PLUGIN_FOLDER_PATH_IMG . $atts['icon'] );
				
		return sprintf( $code, $atts['type'], $atts['subtype'], $speaker_icon_path, $atts['name'], $content );
    }
	
	/**
	* Make arg associated array
	* 
	* Analyse id_sets {id1;arg A} are valid and Make arg A's associated array
	*
	* @param string $id_sets_str
	* @param array &$arg_array
	* @return bool valid arg
	*/
	function make_array_from_idsets( $id_sets_str, &$arg_array ) {
		$idsets_tmp = $id_sets_str;
		$idsets_tmp = str_replace( '}', ':', $idsets_tmp );
		$idsets_tmp = str_replace( '{', '',  $idsets_tmp );
		
		$idsets_tmp = explode( ':', $idsets_tmp );
		
		for( $i = 0; $i < count( $idsets_tmp ); ++$i ) {
			if( $idsets_tmp[i] !== NULL ) {
				$idsets_tmp[i] = rtrim( $idsets_tmp[i] );
			}
		}
		
		$id_arr      = array();
		$type_arr    = array();
		$subtype_arr = array();
		$icon_arr    = array();
		$name_arr    = array();
		
		//$idsets_tmpの配列内容を確かめる $id_argとして配列要素を取り出す
		foreach( $idsets_tmp as $id_arg ) {
			//idを取り出し，配列にする
			array_push( $id_arr,      self::get_sb_id( $id_arg ) );
			array_push( $type_arr,    self::get_sb_arguments_type( $id_arg ) );
			array_push( $subtype_arr, self::get_sb_arguments_subtype( $id_arg ) );
			array_push( $icon_arr,    self::get_sb_arguments_icon( $id_arg ) );
			array_push( $name_arr,    self::get_sb_arguments_name( $id_arg ) );
		}
		
		
		$valid_arr = array();
		//idと引数(type,subtype,icon,name)をチェックして,有効なら連想配列を作成する。
		self::make_valid_id_sets( $valid_arr, $arg_array, $id_arr, $type_arr, $subtype_arr, $icon_arr, $name_arr );
						
		//有効なidsetが見つかれば，
		return TRUE;
	}
	
		
	/**
	* Get sb_id
	* 
	* Check given string is sb_id and Get sb_id argument
	* 
	* @param string $check_sb_id
	* @return string or NULL  (valid=sb_id, invalid=NULL)
	*/
	function get_sb_id( $check_sb_id ) { 
		$check_sb_id = str_replace( array('\r\n', '\n', '\r' ), '', $check_sb_id );
		$match_result = preg_match( '/sb_id=([a-zA-Z0-9_\-\s]*)/u', $check_sb_id, $match_id );
		
		if( 1 === $match_result ) {
			$match_id = $match_id[1];
			
			$chech_result = preg_match( '/([\s|　])/', $match_id, $str_tmp );
			if( 1 === $chech_result ) {
				return self::SB_ALERT_SBID_INCLUDE_WHITESPACE;
			}
		} elseif ( 0 === $match_result ) {
			$match_id = NULL;
		} elseif ( FALSE === $match_result ) {
			$match_id = NULL;
		}
		
		return $match_id;
	}
	
	
	/**
	* Get type
	* 
	* Check given string is type of speech bubble and Get given type from users
	* Make some misspellling or some spaces eliminate.
	* 
	* @param string $check_arguments
	* @return string or NULL  (valid=sb_id, invalid=NULL)
	*/
	function get_sb_arguments_type( $check_arguments ) { 
		$match_result = preg_match('/type=([a-zA-Z0-9\s]*),/u', $check_arguments, $match_type );
		
		if ( 1 === $match_result ) {
			$match_type = preg_replace( '/(\s|　)/', '', $match_type[1] );
			$match_type = str_replace( array( '\r\n', '\n', '\r' ), '', $match_type );
			
			//typeが存在するかを確認して，存在しなければtype_missingを入力
			if( in_array(  FALSE === $match_type, $this->sb_reg_type ) ) {
				$match_type = self::SB_ALERT_TYPE_MISSING;
			}
		} elseif ( 0 === $match_result ) {
			$match_type = NULL;
		} elseif ( FALSE === $match_result ) {
			$match_type = NULL;
		}
		
		return $match_type;
	}
	
	/**
	* Get subtype
	* 
	* Check given string is subtype of speech bubble and Get given subtype from users
	* Make some misspellling or some spaces eliminate.
	* 
	* @param string $check_arguments
	* @return string or NULL  (valid=sb_id, invalid=NULL)
	*/
	function get_sb_arguments_subtype( $check_arguments ) { 
		$match_result = preg_match( '/subtype=([a-zA-Z0-9\s]*),/u', $check_arguments , $match_subtype );
		
		if( 1 === $match_result ) {
			$match_subtype = preg_replace( '/(\s|　)/', '', $match_subtype[1] );
			$match_subtype = str_replace( array( '\r\n', '\n', '\r' ), '', $match_subtype );
			
			$check_res = array_key_exists( $match_subtype, $this->sb_asc_subtype );
			
			//subtypeが存在するかを確認して，存在しなければsubtype_missingを入力
			if( TRUE === $check_res ) {
				$match_subtype = $this->sb_asc_subtype[ $match_subtype ];
			} elseif ( FALSE === $check_res ) {
				$match_subtype = SB_ALERT_SUBTYPE_MISSING;
			}			
		} elseif ( 0 === $match_result ) {
			$match_subtype = NULL;
		} elseif ( FALSE === $match_result ) {
			$match_subtype = NULL;
		}

		return $match_subtype;
	}	
	
	
	/**
	* Get icon filename
	* 
	* Check given string is icon and has extension. Get given subtype from users.
	* Make some misspelling or some spaces eliminate.
	* 
	* @param string $check_arguments
	* @return string or NULL  (valid=sb_id, invalid=NULL)
	*/
	function get_sb_arguments_icon( $check_arguments ) { 
		$match_result = preg_match('/icon=([a-zA-Z0-9._\-\/\s]*),/u', $check_arguments , $match_icon );
		
		if( 1 === $match_result ) {
			$match_icon = preg_replace( '/(\s|　)/', '', $match_icon[1] );
			$match_icon = str_replace( array( '\r\n', '\n', '\r' ), '', $match_icon );
			
			$match_icon = self::check_icon_extension_exists( $match_icon );
		} elseif ( 0 === $match_result ) {
			$match_icon = NULL;
		} elseif ( FALSE === $match_result ) {
			$match_icon = NULL;
		}

		return $match_icon;
	}	
	
	
	/**
	* Get name
	* 
	* Check given string is name. Get given name from users.
	* 
	* @param string $check_arguments
	* @return string or NULL  (valid=sb_id, invalid=NULL)
	*/
	function get_sb_arguments_name( $check_arguments ) { 
		$match_result = preg_match( '/name=(.*)/u', $check_arguments , $match_name );
		
		if( 1 === $match_result ) {
			$match_name = $match_name[1];
		} elseif ( 0 === $match_result ) {
			$match_name = NULL;
		} elseif ( FALSE === $match_result ) {
			$match_name = NULL;
		}

		return $match_name;
	}	

	/**
	* Make valid associated array for replacing.
	* 
	* Check given id_sets is valid , not NULL and Make valid associated array for replacing.
	* 
	* @param array &$valid_arr
	* @param array &$asc_arr
	* @param string  $id
	* @param string  $type
	* @param string  $subtype
	* @param string  $icon
	* @param string  $name
	*/
	function make_valid_id_sets( &$valid_arr, &$asc_arr ,$id, $type, $subtype, $icon, $name ) {
		for( $i = 0; $i < count( $id ); ++$i ) {
			if( NULL !== $id[ $i ] ) {
				if( ( NULL !== $type[ $i + 1 ] ) && ( NULL !== $subtype[ $i + 1 ] )&& ( NULL !== $icon[ $i + 1 ] )&& ( NULL !== $name[ $i + 1 ] ) ) {
					array_push( $valid_arr, TRUE);
					$str_asc_key   = sprintf( "sb_id=%s", $id[ $i ] );
					$str_asc_value = sprintf( "type=\"%s\" subtype=\"%s\" icon=\"%s\" name=\"%s\"", $type[ $i + 1 ], $subtype[ $i + 1 ], $icon[ $i + 1 ], $name[ $i + 1 ] );
					$asc_arr += array( $str_asc_key => $str_asc_value );
				} else {
					array_push( $valid_arr, FALSE );
				}
			} else {
				array_push( $valid_arr, FALSE );
			}
		}
		
		return;
	}
	
}
