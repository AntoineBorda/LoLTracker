<?php

namespace App\Controller\Admin;

use App\Entity\Account\User\RiotInfo;
use App\Entity\App\Tracker\DataCountry;
use App\Entity\App\Tracker\DataLeague;
use App\Entity\App\Tracker\DataTeam;
use App\Entity\App\Tracker\League;
use App\Entity\App\Tracker\Player;
use App\Entity\App\Tracker\Team;
use App\Entity\App\Tracker\Tracker;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_SUPERADMIN')]
    #[Route('/superadmin', name: 'superadmin')]
    public function index(): Response
    {
        return $this->render('pages/admin/index.html.twig', []);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('LoLTracker');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('DataCountry', 'fas fa-list', DataCountry::class);
        yield MenuItem::linkToCrud('DataLeague', 'fas fa-list', DataLeague::class);
        yield MenuItem::linkToCrud('DataTeam', 'fas fa-list', DataTeam::class);
        yield MenuItem::linkToCrud('League', 'fas fa-list', League::class);
        yield MenuItem::linkToCrud('Player', 'fas fa-list', Player::class);
        yield MenuItem::linkToCrud('RiotInfo', 'fas fa-list', RiotInfo::class);
        yield MenuItem::linkToCrud('Team', 'fas fa-list', Team::class);
        yield MenuItem::linkToCrud('Tracker', 'fas fa-list', Tracker::class);
    }
}
