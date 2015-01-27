<?php namespace LangLeap\Videos\RecommendationSystem\ClassificationEngines;

use LangLeap\Videos\RecommendationSystem\Model;

/**
 * The SimilarityClassificationEngine is a simple classification engine that determines
 * whether the classifiable instance's attributes are similar to those
 * defined by the reference model's.
 * @author Alan Ly <hello@alan.ly>
 */
class SimilarityClassificationEngine implements ClassificationEngine {

	/**
	 * Determines the probability that the classifiable instance will meet the
	 * expectations outlined by the reference model.
	 * @param Model $referenceModel The reference model to compare against
	 * @param Model $classifyModel  The model that we want to classify
	 * @return float The likelihood that we will meet expectations
	 */
	public function classify(Model $referenceModel, Model $classifyModel)
	{
		$classifyAttributes = $classifyModel->toArray();
		$totalWeight = 0;
		$weight = 0;

		foreach ($classifyAttributes as $a)
		{
			$refAttr = $referenceModel->{$a->getName()};
			$totalWeight += $refAttr->weight();

			foreach ($a->keys() as $name)
			{
				$weight += $refAttr->count($name);
			}
		}

		if ($totalWeight === 0) return 0;

		return (float)$weight / $totalWeight;
	}

}
