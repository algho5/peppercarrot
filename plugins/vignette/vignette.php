<?php
/**
 * Plugin vignette Pepper&Carrot
 * @package	PLX
 * @version	0.6
 * @date	09/02/2015
 * @author	Rockyhorror, Deevad
 **/
 
class vignette extends plxPlugin {

	/**
	 * Constructeur de la classe vignette
	 *
	 * @param	default_lang	langue par défaut utilisée par PluXml
	 * @return	null
	 * @author	Rockyhorror
	 **/

	public function __construct($default_lang) {
    
  # Appel du constructeur de la classe plxPlugin (obligatoire)
  parent::__construct($default_lang);

  # Déclarations des hooks
  $this->addHook('showVignette', 'showVignette');
  $this->addHook('vignetteArtList', 'vignetteArtList');
  $this->addHook('artPrevNext', 'artPrevNext');
  $this->addHook('artLicense', 'artLicense');
  $this->addHook('artCatUnactive', 'artCatUnactive');
  $this->addHook('commentLinkAuthor', 'commentLinkAuthor');

  # Autorisation d'acces à la configuration du plugins
  $this-> setConfigProfil(PROFIL_ADMIN, PROFIL_MANAGER);
	}
	
	/**
	 * Méthode qui affiche la vignette en mode manuel
	 *
	 * @return	stdio
	 * @author	Rockyhorror
	 **/

	public function showVignette($params) {
		$plxMotor = plxMotor::getInstance();
		
		$vignette = $plxMotor->plxRecord_arts->f('thumbnail');
		if(empty($vignette)) { return; }
		
		if(isset($params)) {
			if(is_array($params)) {
				$pathOnly = !empty($params[0])?$params[0]:false;
				$format = !empty($params[1])?$params[1]:NULL;
			}
			else {
				$pathOnly = !empty($params)?$params:false;
			}
		}
		else {
			$pathOnly = false;
		}
		
    # used to be full path... Why?Let see without.
		#$root_dir = empty($plxMotor->aConf['racine'])?$plxMotor->aConf['racine']:$plxMotor->aConf['racine'];
		#$img = $root_dir.$vignette;
		$img = $vignette;
    
		if($pathOnly) {
			echo $img;
		}
		else {
			if(!isset($format)) { $format = '<img src="#url" alt="image #url" />'; }
			$row = str_replace('#url',$img,$format);
			echo $row;
		}
		
	}
	
	public function vignetteArtList($params) {
    $plxMotor = plxMotor::getInstance();
		$plxShow = plxShow::getInstance();
		
		if(isset($params)) {
			if(is_array($params)) {
				$format = empty($params[0])?'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" />#art_title</a></li>':$params[0];
				$max = isset($params[1])?$params[1]:5;
				$cat_id = empty($params[2])?'':$params[2];
				$ending = empty($params[3])?'':$params[3];
				$sort = empty($params[4])?'rsort':$params[4];
			}
			else {
				$format = empty($params)?'<li><a href="#art_url" title="#art_title"><img src="#art_vignette" />#art_title</a></li>':$params;
			}
		}
		else {
			$format='<li><a href="#art_url" title="#art_title"><img src="#art_vignette" />#art_title</a></li>';
			$max=5;
			$cat_id='';
			$ending='';
			$sort='rsort';
		}
	
		# Génération de notre motif
		if(empty($cat_id))
			$motif = '/^[0-9]{4}.(?:[0-9]|home|,)*(?:'.$plxShow->plxMotor->activeCats.'|home)(?:[0-9]|home|,)*.[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
		else
			$motif = '/^[0-9]{4}.((?:[0-9]|home|,)*(?:'.str_pad($cat_id,3,'0',STR_PAD_LEFT).')(?:[0-9]|home|,)*).[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';

		# Nouvel objet plxGlob et récupération des fichiers
		$plxGlob_arts = clone $plxShow->plxMotor->plxGlob_arts;
		if($aFiles = $plxGlob_arts->query($motif,'art',$sort,0,$max,'before')) {
			foreach($aFiles as $v) { # On parcourt tous les fichiers
				$art = $plxShow->plxMotor->parseArticle(PLX_ROOT.$plxShow->plxMotor->aConf['racine_articles'].$v);
				
				# recupere la vignette
				$vignette = plxUtils::strCheck($art['thumbnail']);
				$vignette_path = empty($vignette)?'':$vignette;
                
                #special vignette for episode lang
                $vignette_parts = pathinfo($vignette_path);
                    # break down vignette path to get most information :
                    $filename = $vignette_parts['filename'];
                    $filename = substr($filename, 3);
                    $episodedir = $vignette_parts['dirname'].'/';
                    
                    # Guess active lang: try many scenario
                    $lang = '';
                    $get = plxUtils::getGets();
                    if(preg_match('/^([a-zA-Z]{2})\/(.*)/', $get, $capture)) {
                      $lang = $capture[1];
                    } elseif(isset($_SESSION['lang'])) {
                      $lang = $_SESSION['lang'];
                    } elseif(isset($_COOKIE["plxMyMultiLingue"])) {
                      $lang = $_COOKIE["plxMyMultiLingue"];
                    } else {
                      $lang = $default_lang;
                    }

                    $translation_check = $episodedir.''.$lang.'_'.$filename.'.'.$vignette_parts['extension'];
                    
                    if (file_exists($translation_check)) {
                    $episode_vignette = $episodedir.''.$lang.'_'.$filename.'.'.$vignette_parts['extension'];
                    } else {
                    $episode_vignette = $episodedir.'en_'.$filename.'.'.$vignette_parts['extension'];
                    }
				
				$num = intval($art['numero']);
				$date = $art['date'];
				if(($plxShow->plxMotor->mode == 'article') AND ($art['numero'] == $plxShow->plxMotor->cible))
					$status = 'active';
				else
					$status = 'noactive';
				# Mise en forme de la liste des catégories
				$catList = array();
				$catIds = explode(',', $art['categorie']);
				foreach ($catIds as $idx => $catId) {
					if(isset($plxShow->plxMotor->aCats[$catId])) { # La catégorie existe
						$catName = plxUtils::strCheck($plxShow->plxMotor->aCats[$catId]['name']);
						$catUrl = $plxShow->plxMotor->aCats[$catId]['url'];
						$catList[] = '<a title="'.$catName.'" href="'.$plxShow->plxMotor->urlRewrite('?categorie'.intval($catId).'/'.$catUrl).'">'.$catName.'</a>';
					} else {
						$catList[] = L_UNCLASSIFIED;
					}
				}
				# On modifie nos motifs
				$row = str_replace('#art_id',$num,$format);
				$row = str_replace('#category_list', implode(', ',$catList), $row);
				$row = str_replace('#art_url',$plxShow->plxMotor->urlRewrite('?article'.$num.'/'.$art['url']),$row);
				$row = str_replace('#art_status',$status,$row);
				$author = plxUtils::getValue($plxShow->plxMotor->aUsers[$art['author']]['name']);
				$row = str_replace('#art_author',plxUtils::strCheck($author),$row);
				$strlength = preg_match('/#art_title\(([0-9]+)\)/',$row,$capture) ? $capture[1] : '65';
				$title = plxUtils::truncate($art['title'],$strlength,$ending,true,true);
				$row = str_replace('#art_title('.$strlength.')','#art_title', $row);
        if (strpos($title, 'by') !== false) {
        $titlecut = str_replace('by', '<br/><span class="detail">by', $title);
        } else {
        $titlecut = $title.'<br/><span class="detail">';
        }
				$row = str_replace('#art_supertitle',$titlecut,$row);
				$row = str_replace('#art_title',$title,$row);
				$strlength = preg_match('/#art_chapo\(([0-9]+)\)/',$row,$capture) ? $capture[1] : '180';
				$chapo = plxUtils::truncate($art['chapo'],$strlength,$ending,true,true);
				$row = str_replace('#art_chapo('.$strlength.')','#art_chapo', $row);
				$row = str_replace('#art_chapo',$chapo,$row);
				$strlength = preg_match('/#art_content\(([0-9]+)\)/',$row,$capture) ? $capture[1] : '100';
				$content = plxUtils::truncate($art['content'],$strlength,$ending,true,true);
				$row = str_replace('#art_content('.$strlength.')','#art_content', $row);
				$row = str_replace('#art_content',$content, $row);
				$row = str_replace('#art_date',plxDate::formatDate($date,'#num_year(4)/#num_month/#num_day'),$row);
				$row = str_replace('#art_hour',plxDate::formatDate($date,'#hour:#minute'),$row);
				$row = plxDate::formatDate($date,$row);
				$commentnumber = $art['nb_com'];
                    if($commentnumber == 0){
                        $row = str_replace('#art_nbcoms','', $row);
                        } else {
                        $row = str_replace('#art_nbcoms',', '.$commentnumber.' <img class="svg" src="themes/peppercarrot-theme_v2/ico/com.svg" alt="com"/>', $row);
                    }
				# On ajoute la vignette
				$row = str_replace('#art_vignette', $vignette_path, $row);
				$row = str_replace('#episode_vignette', $episode_vignette, $row);
				# On genère notre ligne
				echo $row;
			}
		}
	
	}
    
public function artPrevNext($params) {
$plxShow = plxShow::getInstance();

  if(isset($params)) {
    if(is_array($params)) {
      $prevLib = empty($params[0])?'Previous':$params[0];
      $nextLib = empty($params[1])?'Next':$params[1];
    }
  } else {
    $prevLib = 'Previous';
    $nextLib = 'Next';
  }

  $ordre = preg_match('/asc/',$plxShow->plxMotor->tri)?'sort':'rsort';
  $artCatIds = explode(',', $plxShow->plxMotor->plxRecord_arts->f('categorie'));
  $activeCats = explode('|',$plxShow->plxMotor->activeCats);
  $activecat = array_intersect($artCatIds,$activeCats);
  $activecat = ($activecat ? implode('|', $activecat) : '');
  $plxGlob_arts = clone $plxShow->plxMotor->plxGlob_arts;
  $motif = '/^[0-9]{4}.((?:[0-9]|home|,)*(?:'.str_pad($activecat,3,'0',STR_PAD_LEFT).')(?:[0-9]|home|,)*).[0-9]{3}.[0-9]{12}.[a-z0-9-]+.xml$/';
  $aFiles = $plxGlob_arts->query($motif,'art',$ordre,0,false,'before');
  $key = array_search(basename($plxShow->plxMotor->plxRecord_arts->f('filename')), $aFiles);
  $prevUrl = $prev = isset($aFiles[$key-1])? $aFiles[$key-1] : false;
  $nextUrl = $next = isset($aFiles[$key+1])? $aFiles[$key+1] : false;

  if($prev AND preg_match('/([0-9]{4}).[home|0-9,]*.[0-9]{3}.[0-9]{12}.([a-z0-9-]+).xml$/',$prev,$capture)){
    $prevUrl = $plxShow->plxMotor->urlRewrite('?article'.intval($capture[1]).'/'.$capture[2]);
      if ($prev){
      $art = $plxShow->plxMotor->parseArticle(PLX_ROOT.$plxShow->plxMotor->aConf['racine_articles'].$prev);
      $nextTitle = STRIP_TAGS($art['title']);
      }
  }
  if($next AND preg_match('/([0-9]{4}).[home|0-9,]*.[0-9]{3}.[0-9]{12}.([a-z0-9-]+).xml$/',$next,$capture)){
    $nextUrl = $plxShow->plxMotor->urlRewrite('?article'.intval($capture[1]).'/'.$capture[2]);
    if ($next) {
      $art = $plxShow->plxMotor->parseArticle(PLX_ROOT.$plxShow->plxMotor->aConf['racine_articles'].$next);
      $prevTitle = STRIP_TAGS($art['title']);
    }
  }

  if($ordre=='rsort') { 
    $dummy=$prevUrl; $prevUrl=$nextUrl; $nextUrl=$dummy; 
  }

  $theme = $plxShow->plxMotor->aConf['racine_themes'].$plxShow->plxMotor->style.'/';
  $racine= $plxShow->plxMotor->racine;
  $IDcategory = str_pad ($plxShow->catId(), 3, '0', STR_PAD_LEFT);
  
  if ( $IDcategory == "home" ) { 
    $IDcategory = "002" ;
  }
  $IDlinkcategory = ltrim($IDcategory, '0');

  if($prevUrl) {
    echo '<div class="col sml-6 med-4 lrg-4">';
    echo '  <a class="readernavbutton" style="text-align:left;" title="'.$prevTitle.'" href="'.$prevUrl.'">';
    echo '  <img src="themes/peppercarrot-theme_v2/ico/prev.svg" alt=""/>'.$prevLib.'';
    echo '  </a>';
    echo '</div>';
  } else {
    echo '<div class="col sml-6 med-4 lrg-4">';
    echo '  <a class="readernavbutton off" style="text-align:left;" title="'.$prevTitle.'" href="#">';
    echo '  <img src="themes/peppercarrot-theme_v2/ico/prev.svg" alt=""/>'.$prevLib.'';
    echo '  </a>';
    echo '</div>';
  }
  if($nextUrl) {
    echo '<div class="col sml-6 med-4 lrg-4">';
    echo '  <a class="readernavbutton" style="text-align:right;" title="'.$nextTitle.'" href="'.$nextUrl.'">';
    echo '  '.$nextLib.'<img src="themes/peppercarrot-theme_v2/ico/next.svg" alt=""/>';
    echo '  </a>';
    echo '</div>';
  } else {
    echo '<div class="col sml-6 med-4 lrg-4">';
    echo '  <a class="readernavbutton off" style="text-align:right;" title="'.$nextTitle.'" href="#">';
    echo '  '.$nextLib.'<img src="themes/peppercarrot-theme_v2/ico/next.svg" alt=""/>';
    echo '  </a>';
    echo '</div>';
  } 
  
}
    
    public function artLicense() {
        $plxShow = plxShow::getInstance();
        $taglist = $plxShow->plxMotor->plxRecord_arts->f('tags');
        
		if(!empty($taglist)) {
			$tags = array_map('trim', explode(',', $taglist));
			foreach($tags as $idx => $tag) {
				$tagfound = plxUtils::strCheck($tag);
                $tagfull = ''.$tagfound.',';
                $theme = $plxShow->plxMotor->aConf['racine_themes'].$plxShow->plxMotor->style.'/';
                $racine= $plxShow->plxMotor->racine;
                // echo 'debug:'.$tagfull.'';
                
                
                if (strpos($tagfull,'cc-0,') !== false) {
                echo '<a href="http://creativecommons.org/licenses/by/4.0/">License (page+artworks) <span class="cc">CC-BY</span></a><br/> ';
                echo '<a href="https://creativecommons.org/publicdomain/zero/1.0/">License (download) <span class="cc">CC-ZERO</span></a><br/> ';
               
                } elseif (strpos($tagfull,'cc-by,') !== false) {
                echo '<a href="http://creativecommons.org/licenses/by/4.0/">License <span class="cc">CC-BY</span> </a><br/>';
                
                } elseif (strpos($tagfull,'cc-by-sa,') !== false) {
                echo '<a href="http://creativecommons.org/licenses/by-sa/4.0/">License <span class="cc">CC-BY-SA</span> </a><br/> ';
                
                } elseif (strpos($tagfull,'cc-by-nd-nc,') !== false) {
                echo '<a href="http://creativecommons.org/licenses/by-nc-nd/4.0/">License <span class="cc">CC-BY-NC-ND</span> </a><br/> ';
                
                } elseif (strpos($tagfull,'copyrighted,') !== false) {
                echo '<a href="#">License infos: © <span class="cc">COPYRIGHTED</span> </a><br/>';
                
                } elseif (strpos($tagfull,'shop,') !== false) { 
                echo '<a class="button green" href="http://deevad.deviantart.com/prints/"><img class="svg" src="themes/peppercarrot-theme_v2/ico/ink.svg" alt=" "/>&nbsp;&nbsp;Prints available on deviantArt</a><br/><br/> ';
                
                } elseif (strpos($tagfull,'patreon,') !== false) {
                echo '<a class="button red" href="https://www.patreon.com/davidrevoy"><img class="svg" src="themes/peppercarrot-theme_v2/ico/patreon.svg" alt=" "/>&nbsp;&nbsp;Be my patron on https://www.patreon.com/davidrevoy</a><br/><br/> ';
                
                } elseif (strpos($tagfull,'undefined,') !== false) {
                echo '<img alt="Undefined License" style="border-width:0" src="'.$racine.''.$theme.'img/license-undefinitized.png" title="This work has no defined license yet, but the author allowed me to republish it here. The license decision belong to the original author. Contact him or her for usage informations before reusing it. Thank you! -David"/><br/><br/>';
                } else {
                }
			}
		}
	}
    
    public function artCatUnactive($params) {
        $plxShow = plxShow::getInstance();
        if(isset($params)) {
			if(is_array($params)) {
				$separator = empty($params[0])?',':$params[0];
			}
		} else {
                $separator = ',';
		}
		$catIds = $plxShow->artActiveCatIds();
        
		foreach ($catIds as $idx => $catId) { 
            
			if($catId != 'home') {
				# On va verifier que la categorie existe
				if(isset($plxShow->plxMotor->aCats[ $catId ])) {
					# On recupere les infos de la categorie
					$name = plxUtils::strCheck($plxShow->plxMotor->aCats[ $catId ]['name']);
					$url = $plxShow->plxMotor->aCats[ $catId ]['url'];
					if(isset($plxShow->plxMotor->aCats[ $plxShow->plxMotor->cible ]['url']))
						$active = $plxShow->plxMotor->aCats[ $plxShow->plxMotor->cible ]['url']==$url?"active":"noactive";
					else
						$active = "noactive";
					echo ''.$name.'';
				} else { # La categorie n'existe pas
					echo L_UNCLASSIFIED;
				}
			} else { # Categorie "home"
				echo '';
			}
			if ($idx!=sizeof($catIds)-1) echo $separator.' ';
		}
        
	}
    
    public function commentLinkAuthor($params) {
        $plxShow = plxShow::getInstance();
        if(isset($params)) {
			if(is_array($params)) {
				$type = empty($params[0])?'':$params[0];
			}
		} else {
                $type = '';
		}
		$catIds = $plxShow->artActiveCatIds();

		# Initialisation de nos variables interne
		$author = $plxShow->plxMotor->plxRecord_coms->f('author');
		$site = $plxShow->plxMotor->plxRecord_coms->f('site');
		if($type == 'url' AND $site != '')
			echo '<a href="'.$site.'" title="'.$author.'">'.$site.'</a>';
		else # Type normal
			echo ' ';
	}
    
}
?>
