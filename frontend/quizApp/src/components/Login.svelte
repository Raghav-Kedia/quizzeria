<script>
    import { auth, googleProvider } from "../firebase";
    import { authState } from "rxfire/auth";
    import { createEventDispatcher } from "svelte";

    let user = authState(auth);
    const dispatch = createEventDispatcher();

    const checkUser = function () {
        fetch(`http://localhost/quizzeria/backend/quizAppAPI/login.php?user_email=${$user.email}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log(data);
            })
            .catch((error) => {
                console.error("There was a problem with the fetch operation:", error);
            });
        return "";
    };
</script>

{#if $user}
    {dispatch("loggedIn")}
    {checkUser()}
{:else}
    <div id="loginPage">
        <h1>Hi! Welcome to Quizzeria</h1>
        <button id="loginBtn" on:click={() => auth.signInWithPopup(googleProvider)}>Login with Google</button>
    </div>
{/if}

<style>
    h1 {
        color: white;
        font-size: 50px;
        margin-top: 65px;
    }

    #loginBtn {
        padding-block: 30px;
        padding-inline: 40px;
        border-radius: 40px;
        border: 2px solid white;

        font-size: 20px;

        background-color: white;
        color: rgb(104, 44, 201);

        transition: 200ms;
    }

    #loginBtn:hover {
        background-color: rgb(104, 44, 201);
        color: white;
        transition: 200ms;
    }

    #loginBtn:focus {
        background-color: white;
        color: rgb(104, 44, 201);

        /* transition: 100ms; */
    }

    #loginPage {
        width: 50%;
        height: 300px;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;

        text-align: center;

        padding: 50px;
        border-radius: 30px;
        box-shadow: 2px 2px 2px 1px #ac73ff;
        background-color: rgb(128 128 128 / 20%);
        backdrop-filter: blur(15px);
    }
</style>
