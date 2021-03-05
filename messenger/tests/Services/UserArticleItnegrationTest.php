<?php


namespace App\Tests\Services;


use App\Entity\Article;
use App\Services\UserArticle;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserArticleItnegrationTest extends KernelTestCase
{

    protected function setUp(): void
    {
        self::bootKernel();
        $this->truncateEntities();
    }

    public function testItBuildArticle()
    {

        /**
         * @var UserArticle $userArticleService
         */
        $userArticleService = self::$kernel->getContainer()
            ->get('test.'.UserArticle::class);

        $userArticleService->createArticleForUser(3,'test');

        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Article::class)->createQueryBuilder('a')
            ->select('count(a.id)')
            ->getQuery()
            ->getSingleScalarResult();

        $this->assertSame(3,$count);

    }


    private function truncateEntitiesManualy(array $entities)
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();

        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }

        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );

            $connection->executeUpdate($query);
        }

        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }


    public function truncateEntities()
    {
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

}