<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

/**
 * English versions of the Indonesian articles, so the English pages show English articles only.
 * Fills the English columns ONLY when they are empty, so it never overwrites edits made in admin.
 * These are AI-drafted translations: please read them and adjust the wording in admin (Blog posts).
 * The token {{IMAGE_1}} is replaced with the first image already present in the Indonesian body (image paths
 * differ between environments, so they are not hard-coded here).
 */
class PostTranslationSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->translations() as $slug => $t) {
            $post = Post::where('slug', $slug)->first();

            if (! $post || filled($post->title)) {
                continue;
            }

            $body = $t['body'];
            if (str_contains($body, '{{IMAGE_1}}')) {
                preg_match('/!\[[^\]]*\]\([^)]+\)/', (string) $post->body_id, $m);
                $body = str_replace('{{IMAGE_1}}', $m[0] ?? '', $body);
            }

            $post->update(['title' => $t['title'], 'excerpt' => $t['excerpt'], 'body' => trim($body)]);
        }
    }

    /** @return array<string, array{title:string,excerpt:string,body:string}> */
    private function translations(): array
    {
        return [
            'notes-on-my-23-dari-luka-menjadi-karya-dari-bertahan-menjadi-berkembang' => [
                'title' => 'Notes on My 23: From Wounds to Work, From Surviving to Growing',
                'excerpt' => '“It is only when we are brave enough to explore the darkness that we will discover the infinite power of our light.” — Brené Brown',
                'body' => <<<'MD'
> “It is only when we are brave enough to explore the darkness that we will discover the infinite power of our light.” *— Brené Brown*

The date has turned to July 2nd again. If Jakarta witnessed my fragility last year, this year it is cool Bandung that welcomes another turn of the earth in my life.

Celebrating my birthday at 23 feels very different from 22. Last year was about how to keep breathing in the middle of a storm of loss. This year is about learning to fly even though my wings still carry a little pain.

**Looking Back at "Try Hard Mode" in the Rear-View Mirror**

I still remember what I wrote last year. So fragile, so broken. Back then, life felt like it was forcing me to grow up too fast. I had to fight on my own, facing grief while trying to build a blurry future.

*But alhamdulillah*, that "surviving" phase has passed. The coding bootcamp I called a "reckless decision" last year, the one that made me cry and fail almost 8 times on a single submission, turned out to be the main pillar of today's success. The burnout and the tears on those nights full of bugs were not in vain.

> “Perseverance is not a long race; it is many short races one after the other.” *— Walter Elliot*

**The Mechanics of Growth: From Freelance to Software Engineer**

This year brought professional achievements I never imagined. I can still remember what it felt like to land my first freelance project in Makassar, and the joy of being trusted by a lecturer to handle a web project for a province in NTT.

Special thanks to Rizky, a friend who not only invited me to collaborate on that first freelance project, but also became the channel through which God made my dream come true. Through your invitation, I was finally accepted to work as a Software Engineer last March.

There was a phase of insecurity, and tears of relief, because I felt useless while I was still unemployed. But that patience paid off. Thank you to my great seniors: A Taufik, A Iman, and of course Rizky, who accepted me, taught me and walked with me as I grew this far in the industry.

A bit of Indoglish, but the experience was wild. From facing code alone in my room, this year I was given the chance to appear at an event as big as ICI at JIExpo Jakarta. I took part in events at UNPAD, met the artist and former Bandung Barat regent Kang Hengky, and joined a Pertamina workshop at Borobudur Hotel. Overall, I feel very proud and happy to contribute as much as I can to the IT team.

**The Defense Team and the Owners of the Vision**

This month will also be a crucial moment: my final-project defense. Honestly, there is a very heavy weight on my shoulders. But I feel lucky and helped by two extraordinary colleagues, Mas Andre and Mas Apip. Thank you so much for the report and all the support. I don't think I could graduate without the two of you, haha.

Thank you also to the owners of the vision who trusted me. Pak Wendra and Bu Cahya, especially Pak Wendra, thank you for the many opportunities and work challenges. They truly help me grow to face the challenges of the industry ahead.

**Prayers and Hopes for 24**

Last year's piece ended with a prayer for the strength to keep walking. This year's ends with a prayer of gratitude and healthy ambition.

O God, at 23, grant me ease in facing my final-project defense. May I graduate with cum laude honors. There is nothing I want more than to make Mamah happy.

> “We can only know how much our hearts have grown when we see how far our light can travel.”

And to Mamah, my endless thanks. Thank you for always praying for me and always believing in Taufan, even when Taufan himself did not believe in himself. *Love you, Mom.*

Happy 23rd birthday to myself. Thank you for holding on this far, and keep fighting for the years ahead.

*Bandung, July 2, 2026*
MD,
            ],

            'notes-on-my-22-menemukan-kekuatan-di-tengah-kehilangan' => [
                'title' => 'Notes on My 22: Finding Strength in the Midst of Loss',
                'excerpt' => 'In a few hours the date will turn to July 2nd. The same Jakarta where I was born 22 years ago will witness one more turn of the earth around the sun in my life.',
                'body' => <<<'MD'
In a few hours the date will turn to July 2nd. The same Jakarta where I was born 22 years ago will witness one more turn of the earth around the sun in my life.

There is something unique about a mid-year birthday. It is like being given a second chance to reflect on half of the journey before welcoming the other half with a clearer perspective.

#### When Life Forces Us to Grow

At 21, I thought the world would move according to the plan I had neatly laid out. An optimistic IT student in semester 6, with a hidden passion for law and history, hoping to balance the logic of programming with the humanist soul that runs in my blood.

It turns out life has its own way of teaching us about uncertainty.

*“Everyone you meet is fighting a battle you know nothing about. Be kind. Always.”*

October 2024 became the line that split my life into "before" and "after". Someone who taught me the meaning of sincerity was called back by the Almighty because of an illness that could not be overcome. In an instant, I had to learn to let go of someone I had never prepared to lose.

The heavier part? Fighting alone. Being apart from my parents and rarely sharing stories with them meant I had to face that emotional storm with a strength I did not know where it came from.

#### Rising with Try Hard Mode: On

There are moments when we are forced to switch on survival mode. Not because we want to look heroic, but because there is no choice other than to rise or to sink.

I chose to rise, in a way that even surprised myself.

Books became loyal companions. I devoured page after page, looking for answers to questions I could hardly articulate. From Stoic philosophy to biographies of world leaders, I tried to find the pattern in how other people face loss and still move forward.

Then came a reckless decision: joining a JavaScript coding bootcamp with no basics at all. Before that I was only familiar with PHP, but something pushed me to jump into a completely unfamiliar world. Maybe because I wanted to prove, to no one in particular, that I could still learn new things even while my heart was hurting.

*“The expert in anything was once a beginner who refused to give up.”*

Burnout? Of course. There were nights when a syntax error felt like a mirror of my own life, also full of bugs. But every time I finished a challenge, it felt like I was healing the open wound little by little.

#### A Shadow in Every Small Achievement

The strange thing about grieving is how we still want to share our happiness with someone who is no longer here. Every time I got through a hard stage, whether debugging complicated code or grasping a new concept, my mind drifted back to the past.

"If only he could see this," I would murmur to myself.

Deep down I believe he is still watching. From a calmer place, maybe he is smiling proudly at how hard I am trying to climb this steep mountain. Maybe the loss itself is what keeps whispering strength when I am about to give up.

{{IMAGE_1}}

#### Competitions and Ambitions That Are Still Shy

Right now I am preparing for COMPFEST at UI and the TOEFL test. Two challenges that are objectively quite heavy, especially for someone who has just risen from emotional collapse.

I also want to sharpen my negotiation skills for freelance work. Not because I am already an expert in programming, but because I realize I need a more independent financial footing. Ironically, negotiation is the opposite of my personality, which tends to be introverted and sometimes insecure.

*“Your limitation — it’s only your imagination.”*

#### Honest Insecurity

If I am being honest, and this piece is a space for honesty, I am still often visited by doubt. Will I ever be established? Can I make proud the parents I rarely talk to but pray for every night? Or at least, can I be proud of my own achievements?

A funny paradox: even though I have been through a lot and can objectively be said to have come a long way, I am still not entirely proud of myself. Maybe the standard I set is too high, or maybe I have not fully forgiven myself for things I could not control.

#### Friends Who Changed Paths

Being 22 also taught me about friendships that change. Not because of drama or big conflicts, but because everyone starts getting busy with their own path. Friends who used to be available for midnight talks now have to book a schedule just to have coffee together.

This is natural, and I am learning to accept it as part of growing up. What matters is that I keep trying to protect the quality of the relationships, even if the frequency is lower.

#### Reflection for the Taufan to Come

If one day I read this at 30 or 40, I want that older Taufan to smile proudly. Not because he never fell, but because he always tried to get up each time he did.

I want him to know that the 22-year-old Taufan did his best with the resources he had. That even when he was not always confident, he still dared to take risks. That even though he lost many things, he did not lose hope.

*“The best time to plant a tree was 20 years ago. The second best time is now.”*

#### A Prayer for 22

O God, at 22, give me the strength to keep walking even when the road feels heavy. Give me the wisdom to accept what I cannot change, the courage to change what I can, and the intelligence to tell the two apart.

May he be happy in a better place. May my parents always be in Your protection even though we rarely speak. May my friends who are starting to walk different paths find ease in every step.

And for myself: may this year become a strong foundation for building the best version of me.

Happy birthday to myself. Thank you for holding on this far.

*Jakarta, July 2, 2025*
MD,
            ],

            'chatbot-ai-yang-berguna-bukan-yang-terdengar-pintar' => [
                'title' => 'A Chatbot That Is Useful, Not Just Smart-Sounding',
                'excerpt' => 'Connecting an AI model to an app is easy. Building a chatbot that actually solves the user\'s problem is much harder, and that is where the work is.',
                'body' => <<<'MD'
Calling an AI model from an app now takes a few lines of code. The result looks convincing right away: the answers are fluent, tidy and sound smart. Precisely because of that, the hardest part of building a chatbot is often not the technology but deciding **what it should and should not answer**.

#### Start from the user's questions, not from the model

Before choosing a model, write down the fifteen questions people ask your team most often. You will see that most of them are narrow and repetitive. A good chatbot does not need to know everything. It needs to answer those narrow questions correctly, every time.

#### Set clear boundaries

Language models tend to answer even when they do not know. So I treat three things as part of the design, not as extras:

- **A clear source of answers.** Give the model the documents or data it may use, and ask it to answer only from there.
- **A polite "I don't know".** It is better to send the user to a human than to give a wrong answer in a confident tone.
- **Out-of-scope topics.** Decide from the start what must not be answered, such as legal or medical decisions.

#### Measure with real conversations

A good example on a demo screen proves nothing. Collect real conversations, mark which worked and which failed, then improve the instructions and the data based on the failures. The same patterns keep repeating: ambiguous questions, internal terms the model does not know, and outdated data.

#### Design the way out

A chatbot that handles 70 percent of questions well and hands the rest to a human with full context is more useful than one that tries to answer everything. Users usually forgive a chatbot that is honest about its limits. They rarely forgive one that is wrong with full confidence.

In short: the AI model is raw material. The product is the boundaries, the data, and how the chatbot fails gracefully.
MD,
            ],

            'mengotomatiskan-alur-kerja-dengan-n8n' => [
                'title' => 'Automating Workflows with n8n: Start with One Boring Step',
                'excerpt' => 'Automation that lasts usually starts from the one repetitive job that is most boring, not from a grand plan.',
                'body' => <<<'MD'
Every team has small jobs that get repeated again and again: copying data from one place to another, sending notifications, tidying formats, checking whether something is done. Such work is not hard, but it drains attention. That is where an automation tool like **n8n** feels most useful.

#### Pick one job, not one system

The mistake I see most often is starting from the big picture: "let's automate the whole process". A large workflow is hard to test and hard to trust. Pick one job with a clear start and end, do it by hand once while noting the steps, then move those steps into a workflow.

#### Think about triggers and failures first

A workflow that runs on its own must be able to tell you when it fails. Three questions I ask before switching on any workflow:

1. What triggers it, and can that trigger fire twice?
2. What happens if a service in the middle is unavailable?
3. Who is told when a step fails?

Without answers to all three, automation only moves the problem from human hands to a place nobody is watching.

#### Add AI in the right place

An AI model suits steps that need to understand text: summarising, classifying, drafting replies. It suits steps that need absolute certainty less, such as calculating or changing important data. A pattern that works well is AI prepares, and a human or a clear rule decides.

#### Document just enough

One sentence on every workflow about its purpose, its owner and what to do when it stops saves a lot of time months later, when even you have forgotten how it works.
MD,
            ],

            'dari-sitemap-ke-artikel-membangun-pipeline-konten' => [
                'title' => 'From Sitemap to Article: Building a Responsible Content Pipeline',
                'excerpt' => 'A sitemap makes discovering new articles automatic. What decides the quality of the result is the ethics of data collection and how the text is rewritten.',
                'body' => <<<'MD'
One of the projects that taught me the most was building a pipeline that discovers new articles through a **sitemap**, extracts their content, and rewrites it in Indonesian with the help of an AI model. The sources were publications such as Search Engine Journal and Search Engine Land. Technically the flow is simple. What makes it challenging lies elsewhere.

#### A sitemap is a polite way in

A sitemap lists pages together with their update dates. By reading it, the pipeline does not need to crawl a whole site. It only checks what is new since the last visit. This is cheaper and kinder to the source's server.

#### The flow

1. Read the sitemap and pick article URLs that have not been processed yet.
2. Fetch the page, then extract only the main content and drop navigation, ads and the rest.
3. Send the content to an AI model with instructions to rewrite it in Indonesian, with a clear structure and style.
4. Save the result as a draft, not published straight away, then schedule publication.

#### What decides quality

- **Respect the source site's rules.** Read `robots.txt`, leave gaps between requests, and do not overload their server.
- **Do not copy.** Rewriting means composing your own sentences from the same facts. Name the source and link to the original article.
- **Check facts and numbers.** A model can change a number or add a detail that is not in the source. For sensitive topics, human review before publishing is not optional.
- **Record what has been processed**, so the same article is not handled twice.

#### The biggest lesson

Automation makes content production cheap. Precisely because it is cheap, the quality standard has to live inside the workflow itself: a clear source, attribution and a review stage. Without them, what you produce is more text, not more information you can trust.
MD,
            ],

            'belajar-machine-learning-sedikit-sedikit-dengan-kaggle' => [
                'title' => 'Learning Machine Learning a Little at a Time with Kaggle',
                'excerpt' => 'No need to wait for a long stretch of free time. One small dataset, one question and one notebook are enough to start understanding how models work.',
                'body' => <<<'MD'
As a software engineer who uses AI models through APIs every day, I realized there is a gap between using a model and understanding how it is built. My way of shrinking that gap: learning machine learning **a little at a time**, using datasets on Kaggle.

#### Start with a small question

A large dataset is overwhelming. I prefer a small dataset with a clear question, for example "can we estimate this value from the other columns?". A narrow question gives every step a reason.

#### The order I follow

1. **Get to know the data.** Look at its shape, missing values and distribution before touching any model.
2. **Clean just enough.** Most of the time goes here, and that is normal.
3. **Start with the simplest model.** The result becomes a baseline. A more complex model only matters if it beats that baseline.
4. **Split training and test data** before measuring anything, so the result does not fool you.
5. **Write down what you learned.** One paragraph at the end of the notebook about what worked and what did not.

#### What changed in my work

Learning from the data side made me calmer around AI models in products. I notice faster when a result is too good to be true, and I understand better why data quality matters more than the choice of model.

I do not feel like an expert yet, and that is fine. The goal is not a title but a habit: little by little, but regularly.
MD,
            ],
        ];
    }
}
