<?php

namespace App\Command;

use App\Entity\Category;
use App\Service\CategoryService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreateCategoryCommand extends Command
{
    protected static $defaultName = 'app:create-category';

    /** @var CategoryService */
    private $categoryService;

    /**
     * @param CategoryService $categoryService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates a new category.')
            ->setHelp('This command allows you to add new category in db...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->title('New Category');

        $categoryName = $io->ask("Choose a category name");

        if ($categoryName) {
            if($io->confirm("Create the category $categoryName ?")) {
                $category = $this->categoryService->create($categoryName);
                if ($category instanceof Category) {
                    $io->success('Category created.');
                }
            }
        }

        return 0;
    }
}
