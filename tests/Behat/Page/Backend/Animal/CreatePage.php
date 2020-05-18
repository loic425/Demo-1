<?php

/*
 * This file is part of the Monofony demo.
 *
 * (c) Monofony
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Behat\Page\Backend\Animal;

use App\Formatter\StringInflector;
use Behat\Mink\Element\NodeElement;
use Behat\Mink\Exception\ElementNotFoundException;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\AbstractCreatePage;
use Monofony\Bundle\AdminBundle\Tests\Behat\Crud\CreatePageInterface;
use Webmozart\Assert\Assert;

class CreatePage extends AbstractCreatePage implements CreatePageInterface
{
    public function getRouteName(): string
    {
        return 'app_backend_animal_create';
    }

    public function checkValidationMessageFor($element, $message): bool
    {
        $element = StringInflector::nameToCode($element);

        $errorLabel = $this->getElement($element)->getParent()->find('css', '.sylius-validation-error');

        if (null === $errorLabel) {
            throw new ElementNotFoundException($this->getSession(), 'Validation message', 'css', '.sylius-validation-error');
        }

        return $message === $errorLabel->getText();
    }

    public function specifyName(?string $name): void
    {
        $this->getElement('name')->setValue($name);
    }

    public function specifySize(?float $size): void
    {
        $this->getElement('size')->setValue($size);
    }

    public function specifySizeUnit(?string $sizeUnit): void
    {
        $this->getElement('size_unit')->setValue($sizeUnit);
    }

    public function attachImage(string $path): void
    {
        $filesPath = $this->getParameter('files_path');

        $this->getDocument()->clickLink('Add');

        $imageForm = $this->getLastImageElement();

        $imageForm->find('css', 'input[type="file"]')->attachFile($filesPath . $path);
    }

    private function getLastImageElement(): NodeElement
    {
        $images = $this->getElement('images');
        $items = $images->findAll('css', 'div[data-form-collection="item"]');

        Assert::notEmpty($items);

        return end($items);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'name' => '#app_animal_name',
            'size' => '#app_animal_size',
            'size_unit' => '#app_animal_sizeUnit',
            'images' => '#app_animal_images',
        ]);
    }
}