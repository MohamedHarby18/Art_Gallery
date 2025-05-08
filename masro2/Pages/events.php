<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$base = $root . '/art_Gallery';
require_once $base . '/vendor/autoload.php';
require_once '../App/connection.php';

?>
<!DOCTYPE html>
<html lang="en">
<?php require_once '../Partials/head.php'; ?>

<body>
    <?php require_once '../Partials/Header.php'; ?>
    <?php
    // display Event Detials 
    use App\Event;
    use App\Customer;

    $customer;
    if (isset($_SESSION["userId"])) {
        $userId = $_SESSION["userId"];


        $userQuery = "SELECT * FROM users WHERE UserID = $userId;";
        $userResult = $con->query($userQuery);
        $user = $userResult->fetch_assoc();


        $customer = new Customer();
        $customer->setAll($user["Fname"], $user["Lanme"], $user["Email"], $user["Password"], $user["phoneNumber"], $user["Address"], $user["City"], $user["Geneder"],);
    }

    $sql = "SELECT * FROM `events`";
    $events = [];

    try {
        $result = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $EventID = $row['EventID'];
            $Title = $row['Title'];
            $Location = $row['Location'];
            $Date = new DateTime($row['Date']);
            $ArtistID = $row['ArtistID'];
            $res = mysqli_query($con, "SELECT Fname From users where UserID=$ArtistID");
            $r = mysqli_fetch_assoc($res);
            $Artist = $r['Fname'];
            $Image = $row['Image'];
            $City = $row['City'];
            $Description = $row['Description'];

            $event = new Event($EventID, $Title, $Description, $Location, $Date, $City, $Image, $ArtistID);
            $events[] = $event;
        }
    } catch (Exception $e) {
    }
    $cities = [
        "Cairo", "Gharbia", "Alexandria", "Ismailia", "Kafr El Sheikh",
        "Aswan", "Assiut", "Luxor", "New Valley", "North Sinai",
        "El Beheira", "Beni Suef", "Port Said", "Red Sea", "Giza",
        "Dakahlia", "South Sinai", "Damietta", "Sohag", "Suez",
        "Sharqia", "Fayoum", "Qalyubia", "Qena", "Matrouh", "Monufia", "Minya"
    ];
    ?>

    <main class="bg-main py-16 min-h-screen">
        <div>
            <div class="container">
                <select class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state" name="City">
                    <?php foreach ($cities as $city) : ?>
                        <option <?= $city === $customer->getCity() ? 'selected' : '' ?> value="<?= $city ?>"><?= $city ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="container flex flex-wrap xl:gap-x-14">
            <?php foreach ($events as $event) : ?>
                <div data-city=<?= $event->getCity() ?> class="border-b-2 event <?= $event->getCity() !== $customer->getCity() ? "hide" : "" ?> border-b-gray-950  xl:basis-[calc(50%-4rem)] flex gap-8 lg:gap-14  flex-col-reverse md:flex-row justify-between items-center py-14">
                    <div class="info w-10/12">
                        <h3 class="font-bold text-gray-900 text-xl"><?= $event->getTitle() ?></h3>
                        <div class="flex items-center justify-between font-bold text-gray-500 text-sm">
                            <h4>City: <?= $event->getCity() ?></h4>
                            <p><?= $event->getDateTime()->format("j-n-Y") ?></p>
                        </div>
                        <p class="text-gray-500 my-6 font-bold"><?= $event->getDescription() ?></p>

                        <a href="./Pages/event.php?event_id=<?php echo $event->getId() ?>" class="btn mx-auto md:mx-0 w-fit py-2 px-4 rounded-xl block hover:opacity-70 transition bg-black text-white text-sm font-bold ">Details</a>
                    </div>
                    <div class="img">
                        <img class="object-cover w-full" src="../Images/events/<?= $event->getImage() ?>" alt="" />
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

        <?php

        // display Virtual Galleries 
        $sql = "SELECT * FROM `virtualgalleries`";
        try {
            $result = mysqli_query($con, $sql);

            while ($row = mysqli_fetch_assoc($result)) {
                $GalleryID = $row['GalleryID'];
                $Title = $row['Title'];
                $Description = $row['Description'];
                $Date = $row['Date'];

                $ArtistID = $row['ArtistID'];
                $res = mysqli_query($con, "SELECT Fname From users where UserID=$ArtistID");
                $r = mysqli_fetch_assoc($res);
                $Artist = $r['Fname'];

                echo <<<VG
            <div class ="VG-Detials">
            <h1 class="VG-tile">$Title</h1>
            <h4 class="VG-Description">$Description</h4>
            <h5 class="VG-Date">$Date</h5>
            <h5 class="VG-Artist">$Artist</h5>
            </div>
            VG;
            }
        } catch (mysqli_sql_exception $E) {
        }


        ?>
    </main>
    <?php require_once '../Partials/Footer.php'; ?>
    <?php require_once '../Partials/Scripts.php'; ?>
    <script>
        const select = document.querySelector("#grid-state");
        select.addEventListener("change", (e) => {
            const city = e.target.value;
            const events = document.querySelectorAll(".event");
            events.forEach((event) => {
                if(event.dataset.city === city){
                    event.classList.remove("hide");
                }else{
                    event.classList.add("hide");
                }
            });
        });
    </script>
</body>

</html>