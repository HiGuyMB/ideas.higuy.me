<?php

namespace LevelIdeas;

class IdeaList {

	protected $mechanics;

	public function __construct($listFile = "ideas.json") {
		$mechanics = json_decode(file_get_contents($listFile), true);
		$this->mechanics = $mechanics;
	}

	/**
	 * Get a random category
	 * @param array $filters Categories to filter
	 * @return array[]
	 */
	private function getCategory($filters = []) {
		//This variable is henceforth named "Whirligig"
		$cats = [];
		//Filter any that don't allow self-pairing
		$mechanics = array_filter($this->mechanics, function($mechanic) use($filters) {
			foreach ($filters as $filter) {
				if (!$filter["self"] && $mechanic["name"] === $filter["name"]) {
					return false;
				}
			}
			return true;
		});
		//And fill the cats array with different amounts of each based on their chance
		foreach ($mechanics as $mechanic) {
			$cats = array_merge($cats, array_fill(0, $mechanic["chance"], $mechanic));
		}

		return $cats[array_rand($cats)];
	}

	/**
	 * Get two game mechanics
	 * @param int $count
	 * @return string[]
	 */
	public function getGameMechanics($count = 2) {
		//First get some categories
		$categories = [];

		for ($i = 0; $i < $count; $i ++) {
			$categories[] = $this->getCategory($categories);
		}

		//Then get sub-items
		do {
			//Get random items from the categories
			$choices = array_map(function ($list) {
				return array_rand($list["items"]);
			}, $categories);

			//Turn these choice indices into their values
			$items = array_map(function($choice, $list) {
				return $list["items"][$choice];
			}, $choices, $categories);

			//Don't show the same thing twice because that's too funny
		} while (count($items) !== count(array_unique($items)));

		return $items;
	}
}