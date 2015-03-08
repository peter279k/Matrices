<?php

/*
 * This file is part of Matrices.
 *
 * (c) Graham Campbell <graham@mineuk.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace GrahamCampbell\Matrices\Operations;

use GrahamCampbell\Matrices\Matrix;

/**
 * This is the matrix cofactor operation class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class MatrixCofactorOperation implements MatrixOperationInterface
{
    /**
     * Apply the operation to the given matrix.
     *
     * @param \GrahamCampbell\Matrices\Matrix $matrix
     * @param array                           $options
     *
     * @return \GrahamCampbell\Matrices\Matrix
     */
    public static function apply(Matrix $matrix, array $options = [])
    {
        $sign = true;
        $elements = [];

        foreach ($matrix as $row => $iterator) {
            $elements[$row] = [];
            foreach ($iterator as $column => $element) {
                if ($sign) {
                    $elements[$row][$column] = $element;
                    $sign = false;
                } else {
                    $elements[$row][$column] = - $element;
                    $sign = true;
                }
            }
        }

        return new Matrix($elements);
    }
}
