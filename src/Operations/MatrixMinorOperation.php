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

use GrahamCampbell\Matrices\Exceptions\InvalidMatrixException;
use GrahamCampbell\Matrices\Iterators\MatrixRowIterator;
use GrahamCampbell\Matrices\Matrix;
use InvalidArgumentException;

/**
 * This is the matrix minor operation class.
 *
 * @author Graham Campbell <graham@mineuk.com>
 */
class MatrixMinorOperation implements MatrixOperationInterface
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
        $size = $matrix->rows();

        if (!$matrix->square() || $size < 2) {
            throw new InvalidMatrixException('Only square matrices with at least 4 elements have elements with minors.');
        }

        if (!isset($options['row']) || !isset($options['column'])) {
            throw new InvalidArgumentException('The position of the element in the matrix is required.');
        }

        if ($options['row'] >= $size || $options['row'] < 0 || $options['column'] >= $size || $options['column'] < 0) {
            throw new InvalidArgumentException('The position of the element in the matrix must exist in the matrix.');
        }

        return MatrixDeterminantOperation::apply(static::generateMatrix($matrix, $size, $options['row'], $options['column']));
    }

    protected static function generateMatrix(Matrix $matrix, $size, $row, $column)
    {
        $rows = [];

        for ($i = 0; $i < $size; ++$i) {
            if ($i === $row) {
                continue;
            }

            $rows[] = static::generateRow($matrix->row($i), $column);
        }

        return new Matrix($rows);
    }

    protected static function generateRow(MatrixRowIterator $iterator, $column)
    {
        $row = [];

        foreach ($iterator as $index => $element) {
            if ($index === $column) {
                continue;
            }

            $row[] = $element;
        }

        return $row;
    }
}