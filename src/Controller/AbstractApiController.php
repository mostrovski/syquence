<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractApiController extends AbstractController
{
    public function __construct(
        protected ValidatorInterface $validator,
    ) {}

    /**
     * @return array<string,string>
     */
    protected function transformErrors(ConstraintViolationList $errors): array
    {
        $result = [];

        foreach ($errors as $error) {
            $result[$error->getPropertyPath()] = $error->getMessage();
        }

        return $result;
    }
}
