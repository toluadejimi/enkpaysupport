<?php

namespace Database\Seeders;
use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Page::create(['type' => PAGE_TERMS_OF_SERVICE, 'title' => 'Terms Of Service', 'description' => '<div class="text-wraper">
        <h2>Changes to the Terms</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <ul class="list-style-rounded">
            <li>Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam dignissim orci
                dignissim.</li>
            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst faucibus.
            </li>
            <li>ed nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum id odio
                auctor.</li>
            <li>nteger interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam pulvinar.
            </li>
            <li>Pretium consectetur scelerisque blandit habitasse non ullamcorper enim.</li>
        </ul>
        <p>Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames
            tristique dui pharetra elit aliquet morbi. Eget consectetur risus nunc lorem sit consequat
            aliquet. Dolor velit consecte tur etiam scelerisque. Integer interdum sodales scelerisque
            diam massa quam sit quis. Sed et dui a nam pulvinar. Tristique justo, donec lectus vitae,
            cursus ligula ridiculus lacus, tincidunt. Diam dictumst faucib us dui aliquet aenean
            nascetur feugiat leo. Etiam dignissim orci dignissim vitae.</p>
        <p>aliquam eget et viverra risus purus. Commodo fames tristique dui pharetra elit aliquet morbi.
            Eget consectetur risus nunc lorem sit consequat aliquet. Dolor velit consecte tur etiam
            scelerisque. Integer interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam
            pulvinar. Tristique justo, donec lectus vitae, cursus ligula ridiculus lacus, tincidunt.
            Diam dictumst faucib us dui aliquet aenean nascetur feugiat leo. Etiam dignissim.</p>
    </div>
    <div class="text-wraper">
        <h2>Customer’s Obligations to End Users</h2>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
            architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit
            aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
            voluptatem sequi nesciunt.</p>
        <ul class="list-style-rounded">
            <li>Diam dictumst faucibus dui aliquet aenean nascetur feugiat leo Etiam dignissim orci
                dignissim.</li>
            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor Diam dictumst faucibus.
            </li>
            <li>ed nam vulputate pellentesque quis. Varius a, nunc faucibus proin elementum id odio
                auctor.</li>
            <li>nteger interdum sodales scelerisque diam massa quam sit quis. Sed et dui a nam pulvinar.
            </li>
            <li>Pretium consectetur scelerisque blandit habitasse non ullamcorper enim.</li>
        </ul>
    </div>
    <div class="text-wraper">
        <h2>License and Use Rights</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
            labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco
            laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in
            voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat
            cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque
            laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi
            architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit
            aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione
            voluptatem sequi nesciunt.</p>
    </div>
    <div class="text-wraper">
        <h2>Warranties and Disclaimers</h2>
        <p>Blandit dignissim nulla varius tristique a sed integer ut tempor. Augue interdum semper
            bibendum amet sed. Dis in at ultricies tortor sit tellus. Habitant ornare aenean maecenas
            pretium, dui ullamcorper quis. Egestas viverra et id aliquet faucibus rhoncus a.
            Sollicitudin nisl nulla tempor pretium lorem at mauris faucibus pulvinar.</p>
        <ol>
            <li>Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames
                tristique
                dui pharetra elit aliquet morbi aliquam eget et viverra risus purus</li>
            <li> Commodo fames tristique dui pharetra elit aliquet morbi. et consectetur risus nunc
                lorem sit
                consequat aliquet. Dolor velit consectetur etiam scelerisque. Integer interdum sodales
                scelerisque diam
                massa quam sit
            </li>
            <li>ristique justo, donec lectus vitae. cursus ligula ridiculus lacus, tincidunt. Diam
                dictumst faucibus dui
                aliquet aenean nascetur feugiat leo. Etiam dignissim orci dignissim vitae</li>
            <li>Nullam morbi ornare tellus felis. Morbi senectus nibh amet a, pellentesque tincidunt. In
                consectetur
                elementum consectetur facilisis ut eu diam. Pellentesque quam fringilla in egestas id
                consequat.</li>
        </ol>
        <p>Dignissim nulla varius tristique a sed integer ut tempor. Augue interdum semper bibendum amet amet sed. Dis in at ultricies tortor sit tellus. Habitant ornare aenean maecenas pretium, dui ullamcorper quis. Egestas viverra et id aliquet faucibus rhoncus a. Sollicitudin nisl nulla tempor pretium lorem at mauris faucibus pulvinar.Nunc, suspendisse consequat libero, pharetra tellus vulputate auctor venenatis tortor non rhoncus at duis. Pharetra ipsum mauris integer sit feugiat.Eget purus aenean sit risus. Arcu, aliquam eget et viverra risus purus. Commodo fames tristique dui pharetra elit aliquet morbi. Eget consectetu risus nunc lorem sit consequat aliquet.</p>
        <ul>
            <li>Blandit dignissim nulla varius tristique a sed integer ut tempor.</li>
            <li>Id ipsum mi tempor eget. Pretium consectetur scelerisque blandit habitasse non ullamcorper enim</li>
            <li>diam quam id et, tempus massa. Sed nam vulputate pellentesque quis. Varius a, nunc faucibus</li>
        </ul>
    </div>
    <div class="text-wraper">
        <h2>Ownership Rights</h2>
        <p>Malesuada tortor at mattis semper aenean. Tristique nisi pellentesque fringilla ipsum sed amet dui amet mattis. Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus. Sit lacus id pretium malesuada velit.</p>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</p>
    </div>
    <div class="text-wraper">
        <h2>Limitations of Liability</h2>
        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.Eleifend orci sed pulvinar blandit aliquam nisl sed libero amet. Etiam lectus sed enim eu commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</p>
        <ul>
            <li>Blandit dignissim. nulla varius tristique a sed integer ut tempor.</li>
            <li>Id ipsum mi tempor. eget Pretium consectetur scelerisque blandit habitasse non ullamcorper enim</li>
            <li>diam quam id et, tempus massa. Sed nam vulputate pellentesque quis. Varius a, nunc faucibus</li>
            <li>Neque rhoncus in amet ipsum. eget lacus odio. Viverra mus eu amet risus tempor pretium habitant et.</li>
            <li>Etiam lectus sed enim eu. commodo nisi. Tellus vehicula arcu sit egestas porttitor quis faucibus.</li>
        </ul>
    </div>', 'created_by'=>1, 'created_at' => now(), 'updated_at' => now()]);

    }

}
