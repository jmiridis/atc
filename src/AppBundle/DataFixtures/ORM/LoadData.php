<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Client;
use AppBundle\Entity\Destination;
use AppBundle\Entity\Message;
use AppBundle\Entity\Reservation;
use AppBundle\Entity\Transfer;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface
{

    /** @var ContainerInterface */
    private $container;

    /** @var Connection */
    private $connection;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $hostname = 'miridis.com';
        $dbname   = 'sf_atc';
        $username = 'postgres';
        $password = 'D3lph1';

        /** @var \Doctrine\Bundle\DoctrineBundle\ConnectionFactory $connectionFactory */
        $connectionFactory = $this->container->get('doctrine.dbal.connection_factory');
        $this->connection = $connectionFactory->createConnection(
            array('pdo' => new \PDO("pgsql:host=$hostname;dbname=$dbname", $username, $password))
        );

        $this->loadDestinations($manager);
        $this->loadTransfers($manager);
        $this->loadClients($manager);
        $this->loadReservations($manager);
        $this->loadMessages($manager);
        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function loadClients(ObjectManager $manager)
    {
        echo "\nClients ... ";
        $stmt = $this->connection->executeQuery('SELECT * FROM client');

        foreach($stmt->fetchAll() as $i => $record)
        {
            $client = new Client();
            $client->setFirstname($record['firstname']);
            $client->setLastname($record['lastname']);
            $client->setOrigin($record['origin']);
            $client->setPhone($record['phone']);
            $client->setEmailAddress($record['email_address']);
            $client->setIsEmailConfirmed($record['email_confirmed']);
            $client->setCreated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['created_at'])));
            $client->setUpdated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['updated_at'])));
            $manager->persist($client);
            $i += 1;

            $this->addReference("client-".$record['id'], $client);
        }
    }

    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function loadReservations(ObjectManager $manager)
    {
        echo "\nReservations ... ";
        $stmt = $this->connection->executeQuery('SELECT * FROM reservation');

        foreach($stmt->fetchAll() as $record) {
            $reservation = new Reservation();
            $reservation->setClient($this->getReference('client-' . $record['client_id']));
            $reservation->setDestination($this->getReference('destination-' . $record['destination_id']));
            $reservation->setUniqid($record['uniqid']);
            $reservation->setRoundTrip($record['round_trip']);
            $reservation->setNoPax($record['no_pax']);
            $reservation->setHotel($record['hotel']);
            if($record['arrival_date'])
            {
                $reservation->setArrivalDate(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['arrival_date'])));
            }
            $reservation->setArrivalFlightNo($record['arrival_flight_no']);
            if($record['departure_date'])
            {
                $reservation->setDepartureDate(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['departure_date'])));
            }
            $reservation->setDepartureFlightNo($record['departure_flight_no']);
            $reservation->setPrice($record['price']);
            $reservation->setComment($record['comment']);
            $reservation->setStatus($record['status']);
            $reservation->setPaymentDate($record['payment_date']);
            $reservation->setCreated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['created_at'])));
            $reservation->setUpdated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['updated_at'])));
            $manager->persist($reservation);

            $this->addReference("reservation-".$record['id'], $reservation);
        }
    }

    protected function loadDestinations(ObjectManager $manager)
    {
        echo "\nDestinations ... ";

        // 'title','description','active','created_at','updated_at','seq_num','slug),
        $destinations = array(
            array('Cancun Hotel Zone','CANCUN Z. HOTELES',true,'1','cancun-hotel-zone'),
            array('Bahia Petempich','BAHIA PETENPICH',true,'2','bahia-petempich'),
            array('Puerto Morelos','PUERTO MORELOS',true,'5','puerto-morelos'),
            array('Playa del Carmen / Playacar','PLAYA DEL CARMEN / PLAYACAR',true,'6','playa-del-carmen-playacar'),
            array('Akumal - Kantenah','AKUMAL - KANTENAH',true,'8','akumal-kantenah'),
            array('Tulum & Hotel Zone Tulum','TULUM A Z.H TULUM',true,'9','tulum-hotel-zone-tulum'),
            array('Puerto Aventuras','PUERTO AVENTURAS',true,'7','puerto-aventuras'),
            array('Pto. Juarez (Isla Mujeres)','PTO. JUAREZ (ISLA MUJERES)',true,'3','pto-juarez-isla-mujeres'),
            array('Playa Mujeres','PLAYA MUJERES',true,'4','playa-mujeres'),
            array('Chiquila','CHIQUILA',false,'10','chiquila')
        );

        foreach($destinations as $i => $destination)
        {
            list($title, $description, $isActive, $seqNum, $slug) = $destination;
            $destination = new Destination();
            $destination->setTitle($title);
            $destination->setDescription($description);
            $destination->setIsActive($isActive);
            $destination->setSeqNum($seqNum);
            $destination->setSlug($slug);
            $destination->setCreated(new \DateTime());
            $destination->setUpdated(new \DateTime());
            $manager->persist($destination);

            $i += 1;

            $this->addReference("destination-$i", $destination);
        }

    }
    protected function loadTransfers(ObjectManager $manager)
    {
        echo "\nTransfers ... ";

        // id,destination_id,description,min_pax,max_pax,round_trip,price,active,created_at,updated_at),
        $transfers = array(
            array(1,1,4,'RT',70,true),
            array(1,5,10,'RT',85,true),
            array(1,1,4,'OW',45,true),
            array(1,5,10,'OW',60,true),
            array(2,1,4,'RT',65,true),
            array(2,5,10,'RT',80,true),
            array(2,1,4,'OW',43,true),
            array(2,5,10,'OW',65,true),
            array(3,1,4,'RT',80,true),
            array(3,5,10,'RT',95,true),
            array(3,1,4,'OW',55,true),
            array(3,5,10,'OW',60,true),
            array(4,1,4,'RT',110,true),
            array(4,5,10,'RT',135,true),
            array(4,1,4,'OW',70,true),
            array(4,5,10,'OW',80,true),
            array(7,1,4,'RT',140,true),
            array(7,5,10,'RT',150,true),
            array(7,1,4,'OW',80,true),
            array(7,5,10,'OW',85,true),
            array(5,1,4,'RT',145,true),
            array(5,5,10,'RT',160,true),
            array(5,1,4,'OW',90,true),
            array(5,5,10,'OW',100,true),
            array(6,1,4,'RT',160,true),
            array(6,5,10,'RT',190,true),
            array(6,1,4,'OW',100,true),
            array(6,5,10,'OW',110,true),
            array(8,1,4,'RT',75,true),
            array(8,1,4,'OW',45,true),
            array(8,5,10,'RT',80,true),
            array(8,5,10,'OW',53,true),
            array(9,1,4,'RT',79,true),
            array(9,1,4,'OW',50,true),
            array(9,5,10,'RT',105,true),
            array(9,5,10,'OW',65,true),
            array(10,1,4,'RT',10,false),
            array(10,1,4,'OW',240,true),
            array(10,5,10,'RT',10,false),
            array(10,5,10,'OW',190,true)
        );

        foreach($transfers as $transfer)
        {
            list($destinationId, $minPax, $maxPax, $roundTrip, $price, $isActive) = $transfer;
            $transfer = new Transfer();
            /** @var Destination $destination */
            $destination = $this->getReference("destination-$destinationId");
            $transfer->setDestination($destination);
            $transfer->setMinPax($minPax);
            $transfer->setMaxPax($maxPax);
            $transfer->setRoundTrip($roundTrip);
            $transfer->setPrice($price);
            $transfer->setIsActive($isActive);
            $transfer->setCreated(new \DateTime());
            $transfer->setUpdated(new \DateTime());
            $manager->persist($transfer);
        }
    }

    /**
     * @param ObjectManager $manager
     * @throws \Doctrine\DBAL\DBALException
     */
    protected function loadMessages(ObjectManager $manager)
    {
        echo "\nMessages ... ";
        $stmt = $this->connection->executeQuery('SELECT * FROM message');

        foreach($stmt->fetchAll() as $record) {
            $message = new Message();
            if($record['client_id'])
            {
                $message->setClient($this->getReference('client-' . $record['client_id']));
            }
            $message->setEmailAddress($record['client_id']? $record['client_id'] : '');
            $message->setMessage($record['message']);
            $message->setCreated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['created_at'])));
            $message->setUpdated(\DateTime::createFromFormat('Y-m-d H:i:s', preg_replace('/\.[0-9]+$/', '', $record['updated_at'])));
            $manager->persist($message);
        }
    }
}

