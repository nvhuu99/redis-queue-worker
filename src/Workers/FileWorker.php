<?php
namespace App\Workers;

use App\QueueWorker;

class FileWorker implements QueueWorker
{
    public function label(): string
    {
        return 'file';
    }

    public function handle(string $command): void 
    {
        file_put_contents('tmp/output-'.microtime(true), $this->content());   
    }

    private function content(): string
    {
        return "Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo veniam, officiis ipsum eaque culpa quasi voluptatibus laboriosam? Sapiente, iusto! Provident odio totam veritatis cum accusantium, voluptate rerum id odit libero accusamus rem velit eum quidem illo omnis eius. Beatae tempore, soluta pariatur ipsam ex asperiores saepe molestiae enim! Quae culpa tenetur quo facere sed aut fugiat quisquam rem natus quas nostrum illum, dolore saepe doloribus veniam esse atque aliquid similique maxime! Necessitatibus quasi laborum in eum iste eius sequi consequatur labore praesentium officiis deserunt molestias ipsa pariatur odit voluptates, minima quisquam vitae? Eius porro atque rem placeat temporibus impedit cumque omnis, possimus fuga nostrum ducimus, quisquam sequi ad necessitatibus hic. Consequatur voluptate expedita exercitationem rem quasi explicabo cumque cupiditate tenetur, numquam ipsam enim dolorem nisi debitis dolore adipisci voluptatibus nihil temporibus corporis quis blanditiis inventore! Assumenda harum molestiae omnis accusantium nisi ut totam consequatur est similique asperiores dolore, incidunt dicta ad facilis quaerat suscipit perferendis excepturi architecto laboriosam id quasi delectus enim! Deserunt earum architecto dolores aut, reiciendis quibusdam repudiandae quam excepturi cumque. Eligendi sapiente minus consequuntur excepturi similique tempore doloribus, nemo adipisci. Autem obcaecati saepe repellat id ex voluptatem aliquid. Quos soluta quod labore! Id sequi voluptatem voluptatibus nulla sapiente provident eaque suscipit tempore rem vel eum doloremque nobis et eius qui iste quam dicta, dignissimos, facilis sed? Distinctio pariatur quas vitae rem architecto, eos dicta quam iste dolore, suscipit quibusdam quaerat dignissimos, aut illum exercitationem? In dolore nesciunt sunt a ex, sit exercitationem amet reprehenderit totam adipisci eius aut laudantium rem aperiam doloremque iste suscipit ipsa! Possimus voluptas expedita qui ratione. Facere, maiores dignissimos nobis ex rerum illo reiciendis magnam adipisci et illum ad architecto tenetur ab quam provident earum similique minima at? Eveniet iure earum, facere, eligendi suscipit in ut blanditiis sint non minus voluptas? Corporis porro distinctio placeat? Provident voluptatem veniam corrupti, itaque ut perferendis maxime illum molestiae magni! Minima laboriosam deserunt ex illum ea perspiciatis velit reprehenderit voluptatum vel, laborum, temporibus ratione omnis possimus consequuntur maiores. Esse ex blanditiis quidem sed exercitationem maiores explicabo enim adipisci, quos sint numquam atque vero, harum nulla culpa, nostrum dolor iusto? Eos voluptatibus iure quisquam excepturi pariatur provident numquam voluptate adipisci nobis, similique optio? Obcaecati, quibusdam corporis, culpa hic facere optio qui impedit maxime nisi molestiae in vero ullam nostrum quidem magnam id doloribus! Optio eaque molestiae unde, quaerat vitae adipisci voluptatem molestias eum, est cum numquam quos inventore facere eos cupiditate! Quasi eveniet qui praesentium. Iste accusantium consectetur, cumque ipsum recusandae esse molestiae, magni placeat amet eos vitae distinctio ullam, veritatis incidunt animi? Quod hic iusto temporibus debitis libero! Facilis quos assumenda amet nostrum laboriosam eum, voluptate doloribus, ab suscipit sed esse. Placeat nisi similique iure ut quasi, repudiandae eos debitis eligendi voluptates vel ullam? Voluptates tempore et corrupti quia temporibus corporis dolores unde cum libero, optio ex adipisci. Libero fugit dignissimos, veritatis aliquid ullam, beatae vitae quaerat asperiores perspiciatis blanditiis voluptate corporis illo architecto deleniti impedit consectetur qui, adipisci sint voluptatum rem? Veritatis rerum, sit iste natus iure placeat consequatur blanditiis consectetur voluptatum inventore incidunt, magnam nemo possimus, ipsam ex quo aliquid aut recusandae nobis molestias? Fuga consequatur et repellat dignissimos, officiis ipsum! Numquam architecto ad explicabo quos neque accusamus? Earum, voluptatem cupiditate culpa expedita tempore ullam soluta in recusandae porro ea dolor sunt dolorum incidunt? Unde, libero a illo enim ab repellat dolores obcaecati et ipsum, iusto soluta ipsa quibusdam molestiae aliquam? Officia doloremque voluptate iste, ratione ut delectus. Fugiat dignissimos asperiores itaque sapiente odit delectus tenetur accusantium animi at iure, eos laudantium natus quaerat reiciendis in magnam laboriosam veniam, totam quo velit illum ad? Nam culpa sit quidem accusamus animi fugiat magnam ullam, voluptatum laborum ducimus est odio voluptates explicabo earum iusto aperiam laudantium suscipit. Placeat quod, temporibus ipsa laudantium incidunt quisquam eveniet saepe in! Quo atque, fugiat tempora dolorem ipsum cumque doloribus officia saepe quos magni in beatae, odit reiciendis! Assumenda quaerat eaque ea, repudiandae consequatur accusantium, odit eos asperiores sit id reprehenderit totam necessitatibus. Cumque, reprehenderit, iste nesciunt inventore, dignissimos quae officia nisi ex et asperiores alias qui! Quis sapiente atque aliquam recusandae veritatis velit ipsa quos expedita molestiae impedit enim vel eos similique dolores dolorum provident, eveniet magnam. Saepe est ut at omnis, enim officiis unde error minus. Nostrum sequi, ad quam fugiat aliquid ratione inventore autem accusamus aut ducimus et. Maxime vero sit ea sapiente itaque minus veniam consequatur molestias fuga dolores quo repudiandae natus, iure beatae, hic impedit nulla distinctio, sed tempora qui explicabo tenetur cum! Quibusdam amet commodi iure quae incidunt, porro quasi eius pariatur ad. Sint atque pariatur quo maiores voluptatibus magni, architecto aliquid eligendi impedit laudantium perferendis at animi quod iste cupiditate fugiat eos libero corporis nulla accusamus dicta! Iste dolorum minus magnam a libero ipsum sed deserunt ut, fuga corrupti unde assumenda minima, odio iure facilis praesentium quas debitis, laborum quod vitae ipsa dignissimos saepe eaque? Accusantium quisquam, rem eos blanditiis veritatis officia ratione iure eius non facilis sint cum atque reiciendis repellat minus nam laborum et labore nostrum error natus dolor. Facilis consequuntur quo dolor numquam architecto, unde itaque eaque possimus voluptatem officia earum minus sequi, odio quasi cupiditate facere nulla soluta. Quidem, beatae dolorem illo sit totam voluptas suscipit maxime, distinctio dolorum cupiditate provident delectus omnis pariatur perspiciatis aut ipsam. Inventore est officiis pariatur incidunt quos nihil magnam sunt, at fuga similique. Suscipit quia unde sit esse fuga at ipsam ab maiores ullam dolorem rerum culpa beatae, eaque quas magnam doloremque nam? In iure provident esse qui eius ad natus, nulla aut facilis quam totam molestias magni suscipit dolores nobis accusamus reiciendis nesciunt beatae voluptas. Tempore repellat consectetur laudantium iure accusantium repudiandae amet nemo velit iusto deserunt quas doloremque dolorum pariatur illum sed culpa perferendis, harum quo totam id soluta exercitationem dolorem laboriosam. Blanditiis ipsam labore, ratione vero neque assumenda, nihil eum consequatur iste, deleniti hic fugit minus numquam est. Nihil, fuga? Maxime cum sed dolorum quisquam provident id nam quia, facilis rerum nesciunt ratione officia impedit doloremque optio illo magni consequatur adipisci sequi.";
    }
}