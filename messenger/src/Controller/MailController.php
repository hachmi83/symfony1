<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ArticleFormType;
use App\Form\UserFormType;
use App\Message\Command\AddToUser;
use App\Message\Command\DeleteUser;
use App\Message\Command\LogEmoji;
use App\Message\Event\UserUpdatedEvent;
use App\Message\Command\MinusToUser;
use App\Message\Command\UpdateUser;
use App\Message\Query\GetTotalUserCount;
use App\Repository\UserRepository;
use App\Services\UserArticle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends AbstractController
{
    /**
     * @Route("/", name="user_list")
     */
    public function index(UserRepository $userRepository, MessageBusInterface $queryBus, UserArticle $userArticle): Response
    {
        $envelope = $queryBus->dispatch(new GetTotalUserCount());
        /**
         * @var HandledStamp $handled
         */
        $handled = $envelope->last(HandledStamp::class);
        $userCount = $handled->getResult();

        $userArticle->createArticleForUser(3,"film");


        return $this->render("mail/list.html.twig",
            [
                'users' => $userRepository->findBy(['deleteUser' => false]),
                'userCount' => $userCount
            ]);

    }

    /**
     * @Route("/{id}/add", name="user_add", methods={"POST"})
     */
    public function add(User $user, MessageBusInterface $messageBus, EntityManagerInterface $entityManager)
    {

        // start sync
        $user->addCompter();
        $entityManager->flush();
        // end sync

        // strat async
        $message = new AddToUser($user->getId());
        $envelope = new Envelope($message, [
         //   new DelayStamp(500)
        ]);
        $messageBus->dispatch($envelope);
        // end async

        $messageBus->dispatch(new LogEmoji(1));

        return $this->json(['compter' => $user->getCompter()]);
    }

    /**
     * @Route("/{id}/minus", name="user_minus", methods={"POST"})
     */
    public function minus(User $user, MessageBusInterface $messageBus, EntityManagerInterface $entityManager)
    {
        $user->minusCompter();
        $entityManager->flush();

        $message = new MinusToUser($user->getId());
        $messageBus->dispatch($message);

        return $this->json(['compter' => $user->getCompter()]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete")
     */
    public function delete(User $user, MessageBusInterface $messageBus, EntityManagerInterface $entityManager)
    {

        $message = new DeleteUser($user->getId());
        $messageBus->dispatch($message);

        return $this->json(null,Response::HTTP_OK);
    }

    /**
     * @Route("/{id}/update", name="user_update")
     */
    public function update(User $user, MessageBusInterface $messageBus)
    {

        $message = new UpdateUser($user->getId());
        $messageBus->dispatch($message);

        return $this->json(['status'=>$user->status()],Response::HTTP_OK);
    }

    /**
     * @Route("/new", name="user_new")
     */
    public function new(EntityManagerInterface $entityManager, Request $request)
    {
        $form = $this->createForm(UserFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var User $article
             */
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'user created !');

            return $this->redirectToRoute('user_list');

        }

        return $this->render('mail/new.html.twig',
            [
                'userForm' => $form->createView()
            ]);
    }

}
