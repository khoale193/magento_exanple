<?php
namespace Lakhoa\ObjectManager1\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloKhoa extends AbstractCommand
{
    protected function configure()
    {
        $this->setName('lakhoa:object-manager-1');
        $this->setDescription('A cli playground for testing commands');
        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // 1. Instantiate an object from the class
//        $output->writeln("Hello Khoa!");
//        $exampleModel = new \Lakhoa\ObjectManager1\Model\Example;
//        $message = $exampleModel->getHelloMessage();
//        $output->writeln(
//            $message
//        );

        $manager = $this->getObjectManager();
        // 2. Object manager instantiates a "Example" for us
//        $exampleModel = $manager->create('Lakhoa\ObjectManager1\Model\Example');
//        $message = $exampleModel->getHelloMessage();
//        $output->writeln(
//            $message
//        );

        // 3. The second time we called get Magento returned the original object with a custom message set
        $exampleModel = $manager->get('Lakhoa\ObjectManager1\Model\Example');
        $exampleModel->message = 'Hello PHP!';
        $output->writeln(
            $exampleModel->getHelloMessage()
        );

        $anotherExampleModel = $manager->get('Lakhoa\ObjectManager1\Model\Example');
        $output->writeln(
            $anotherExampleModel->getHelloMessage()
        );
    }
}