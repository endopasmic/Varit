<?php
	class IngredientsController extends AppController{
		public function index(){

			//$ingredients = $this->ingredient->find('all');//link to model find all row
			$this->set('ingredients', $this->ingredient->find('all'));// create vallue from model name ingredients
		}
	}


?>