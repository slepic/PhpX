<?php

namespace PhpX\Collections;

/**
 * Interface for objects which can also set their state using an array.
 *
 * This allows manipulation of the state through PHP built-in array functions.
 *
 * The class implementing this interface may have restrictions on the format of the array holding its state.
 * And naturaly the restrictions are expected to be obeyed on the output as well.
 * Meaning the following is expected to never throw an error:
 * 	$x->exchangeArray($x->getArrayCopy());
 * On the other hand, the following code may fail if there is a type check on the elements
 * and $anotherItem is not of expected type.
 * Or this may fail if there is an upper limit on number of elements of the array, etc.
 * 	$copy = $x->getArrayCopy();
 *	$copy[] = $anotherItem;
 * 	$x->exchangeArray($copy);
 *
 * example
 *
 * $x = new class implements ArrayExchangableInterface {...};
 *
 * $usedBuiltInFunction = \array_keys($x->getArrayCopy());
 * $x->exchangeArray($usedBuiltInFunction);
 *
 * //or use object-style wrapper
 * $a = new ArrayObject($x->getArrayCopy());
 *
 * $a = $a->push($item1)
 * 	->removeFirst();
 * 	->filter('is_string');
 * 	->map('trim');
 *
 * all until now you could do with the aggregate itself, but here comes the point when (if you did everything right)
 * you can update the state of the interface implementation instance through the modified array.
 *
 * $x->exchangeArray($a->getArrayCopy());
 *
 * //$x now contains manipulated content without need to explicitly define methods to achieve such manipulation.
 *
 * $x->getArrayCopy(); //can continue manipulation the same way
 */
interface ArrayExchangableInterface extends ArrayAggregateInterface
{
    /**
     * Set object state by its array representation.
     *
     * @param array $array
     * @return void
     */
    public function exchangeArray(array $array);
}
