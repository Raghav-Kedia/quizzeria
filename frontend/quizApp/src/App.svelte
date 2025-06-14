<script>
    import Login from "./components/Login.svelte";
    import Home from "./components/Home.svelte";
    import NewQuiz from "./components/NewQuiz.svelte";
    import ShowQuiz from "./components/ShowQuiz.svelte";
    import AttemptQuiz from "./components/AttemptQuiz.svelte";
    // import Test from "./components/Test.svelte";
    import { auth } from "./firebase";
    import { authState } from "rxfire/auth";

    let user = authState(auth);

    let page = 1;
</script>

{#if page == 1}
    <Login on:loggedIn={() => (page = 2)} />
{:else if page == 2}
    <Home
        on:loggedOut={() => (page = 1)}
        on:newQuiz={() => (page = 3)}
        on:attemptQuiz={() => (page = 4)}
        on:showQuiz={() => (page = 5)}
    />
    <!--on:testPage={() => (page = 6)} -->
{:else if page == 3}
    <NewQuiz user_email={$user.email} on:quizSaved={() => (page = 2)} on:goBack={() => (page = 2)} />
{:else if page == 4}
    <AttemptQuiz user_email={$user.email} on:goBack={() => (page = 2)} />
{:else if page == 5}
    <ShowQuiz user_email={$user.email} on:goBack={() => (page = 2)} />
{/if}

<style>
</style>
