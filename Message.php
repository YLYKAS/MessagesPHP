<?php 
	
	class Message {

		public $errors = array();
		public $news = array();

		public function __construct() {

			if (!empty($_SESSION[__CLASS__])) {

				if (!empty($_SESSION[__CLASS__]['errors'])) {
					foreach ($_SESSION[__CLASS__]['errors'] as $key => $value) {
						$this->errors[$key] = $value;
					}
				}

				if (!empty($_SESSION[__CLASS__]['news'])) {
					foreach ($_SESSION[__CLASS__]['news'] as $key => $value) {
						$this->news[$key] = $value;
					}
				}	
				
				unset($_SESSION[__CLASS__]);
			}

		}

		public function setError($errorType = null) {

			/* --------------- EMPTY ------------------- */

			if ($errorType == 'emptyForm') {
				$this->errors['form'] = 'Aucune données reçu. Veuillez remplir le formulaire.';
			} elseif ($errorType == 'emptyEmail') {
				$this->errors['email'] = 'Veuillez entrer votre email.';
			} elseif ($errorType == 'emptyPassword') {
				$this->errors['password'] = 'Veuillez entrer un mot de passe.';
			} elseif ($errorType == 'emptyFirstname') {
				$this->errors['lastname'] = 'Veuillez entrer votre nom.';
			} elseif ($errorType == 'emptyLastname') {
				$this->errors['firstname'] = 'Veuillez entrer votre prénom.';
			} elseif ($errorType == 'emptyMatricule') {
				$this->errors['matricule'] = 'Veuillez entrer votre matricule.';
			} elseif ($errorType == 'emptyPhonenumber') {
				$this->errors['phonenumber'] = 'Veuillez entrer votre numéro de téléphone.';
			} elseif ($errorType == 'emptyBirthdate') {
				$this->errors['birthdate'] = 'Veuillez entrer votre date de naissance.';
			} elseif ($errorType == 'emptyServices') {
				$this->errors['services'] = 'Veuillez entrer votre service.';

			/* --------------- INVALID ------------------- */

			} elseif ($errorType == 'invalidEmail') {
				$this->errors['email'] = 'L\'addresse email que vous avez saisie est refusée : format invalide.';
			} elseif ($errorType == 'invalidLastname') {
				$this->errors['lastname'] = 'Le nom que vous avez saisie est refusé : format invalide.';
			} elseif ($errorType == 'invalidFirstname') {
				$this->errors['firstname'] = 'Le prénom que vous avez saisie est refusé : format invalide.';
			} elseif ($errorType == 'invalidMatricule') {
				$this->errors['matricule'] = 'Le matricule que vous avez saisie est refusé : format invalide.';
			} elseif ($errorType == 'invalidPhonenumber') {
				$this->errors['phonenumber'] = 'Le numéro de téléphone que vous avez saisie est refusé : format invalide.';
			} elseif ($errorType == 'invalidBirthdate') {
				$this->errors['birthdate'] = 'La date de naissance que vous avez saisie est refusé : format invalide.';
			} elseif ($errorType == 'invalidServices') {
				$this->errors['services'] = 'Le service que vous avez saisie est refusé : choix non-disponible.';
			} elseif ($errorType == 'invalidCaptcha') {
				$this->errors['captcha'] = 'Le captcha a été refusée.';

			/* --------------- WRONG ------------------- */

			} elseif ($errorType == 'wrongEmail') {
				$this->errors['email'] = 'L\'addresse email que vous avez saisie n\'est pas dans notre base de données';
			} elseif ($errorType == 'wrongPassword') {
				$this->errors['password'] = 'Le mot de passe est incorecte.';

			/* --------------- ALREADY ------------------- */

			} elseif ($errorType == 'alreadyEmail') {
				$this->errors['email'] = 'L\'adresse email que vous avez saisie est déjà utilisée.';
			} elseif ($errorType == 'alreadyMatricule') {
				$this->errors['matricule'] = 'Le matricule que vous avez saisie est déjà utilisée.';

			/* --------------- NOT ------------------- */

			} elseif ($errorType == 'notValidated') {
				$this->errors['flash'] = 'Votre compte n\'a pas encore été validé par les administrateurs, veuillez réessayer plus tard';
			} elseif ($errorType == 'notAdmin') {
				$this->errors['flash'] = 'Vous n\'êtes pas administrateur.';


			/* --------------- UNKNOW ------------------- */	

			} else {
				$this->errors['flash'] = 'Un problème est survenue : '.$errorType;
			}
		}

		public function setNews($newsType = null, $color = 'w3-text-green') {

			if ($newsType == 'registrationOk') {
				$this->news['flash'] = 'Votre inscription s\'est bien passée.';
			} elseif ($newsType == 'updateOk') {
				$this->news['flash'] = 'Les modification ont bien été prises en compte.';
			} else {
				$this->news['flash'] = $newsType;
			}

			$this->news['color'] = $color;
		}

		private function surroundElement($html, $class = null, $text) {
			$element =  '<'.$html.' class="'.$class.'">'.$text.'</'.$html.'>';
			return $element;
		}

		public function getError($errorName = null) {

			if (!empty($this->errors[$errorName])) {
			
				return $this->surroundElement('p', 'w3-text-red', $this->errors[$errorName]);


			} elseif ($errorName == null && !empty($this->errors['flash'])) {

				return $this->errors['flash'];

			} else {
				return null;
			}	
		}

		public function getNews($newsName = null) {

			if (!empty($_SESSION['message']['news'][$newsName])) {
				return $this->surroundElement('p', $this->news['color'], $_SESSION['message']['news'][$newsName]);
			} elseif ($newsName === null && !empty($this->news['flash'])) {
				return $this->surroundElement('p', $this->news['color'], $this->news['flash']);
			} else {
				return null;
			}		
		}

		public function hasError() {
			if (!empty($this->errors)) {
				return true;
			} else {
				return false;
			}
		}

		public function saveMessage() {
			$_SESSION[__CLASS__] = array();
			$_SESSION[__CLASS__] = json_decode(json_encode($this), True);
		}

	}