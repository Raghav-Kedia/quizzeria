<script>
    import { auth } from "../firebase";
    import { authState } from "rxfire/auth";
    import { createEventDispatcher } from "svelte";
    import NavBar from "./NavBar.svelte";

    let user = authState(auth);
    const dispatch = createEventDispatcher();

    const logOut = function () {
        auth.signOut().then((res) => {
            dispatch("loggedOut");
        });
    };
</script>

<NavBar {...$user} />

<div id="container">
    <button on:click={() => dispatch("newQuiz")}>Create New Quiz</button>
    <button on:click={() => dispatch("attemptQuiz")}>Attempt Quiz</button>
    <button on:click={() => dispatch("showQuiz")}>Show My Quizes</button>
    <!-- <button on:click={() => dispatch("testPage")}>Test Page</button> -->
    <button on:click={logOut}>Log Out</button>
</div>

<style>
    #container {
        width: 50%;
        height: 80%;
        border-radius: 30px;
        background-color: rgb(128 128 128 / 20%);
        backdrop-filter: blur(5px);
        margin-top: 30px;
        box-shadow: 2px 2px 2px 1px #ac73ff;
        margin-inline: auto;
        align-items: center;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
    }

    button {
        width: 50%;
        padding-block: 30px;
        border-radius: 40px;
        border: 2px solid white;

        font-size: 20px;

        background-color: white;
        color: rgb(104, 44, 201);

        transition: 200ms;
    }

    button:hover {
        background-color: rgb(104, 44, 201);
        color: white;
        transition: 200ms;
    }

    button:focus {
        background-color: white;
        color: rgb(104, 44, 201);
    }
</style>
