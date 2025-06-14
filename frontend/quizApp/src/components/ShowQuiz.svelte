<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let user_email;
    let chosen_id = "";

    const get_quiz_ids = function () {
        return fetch(`http://localhost/quizzeria/backend/quizAppAPI/get_user_quizes.php?user_email=${user_email}`)
            .then((response) => {
                // Check if the response is OK (status code 200)
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                // Parse the response as JSON
                return response.json();
            })
            .then((data) => {
                // Handle the response data
                return data;
            })
            .catch((error) => {
                // Handle errors
                console.error("There was a problem with the fetch operation:", error);
            });
    };

    const get_quiz_attempts = function (id) {
        return fetch(`http://localhost/quizzeria/backend/quizAppAPI/get_quiz_attempts.php?quiz_id=${id}`)
            .then((response) => {
                // Check if the response is OK (status code 200)
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                // Parse the response as JSON
                return response.json();
            })
            .then((data) => {
                // Handle the response data
                return data;
            })
            .catch((error) => {
                // Handle errors
                console.error("There was a problem with the fetch operation:", error);
            });
    };
</script>

<div class="container">
    {#await get_quiz_ids()}
        <h1>Fetching quizzes from database...</h1>
    {:then response}
        <input list="quiz_id_list" id="quizIdSelector" placeholder="Select Quiz ID" bind:value={chosen_id} />
        <datalist id="quiz_id_list">
            {#each response as quiz_id}
                <option value={quiz_id}></option>
            {/each}
        </datalist>
        {#if response.includes(parseInt(chosen_id))}
            {#await get_quiz_attempts(chosen_id)}
                <h1>Getting scores...</h1>
            {:then res}
                {#if res["msg"]}
                    <h1>{res["msg"]}</h1>
                {:else}
                    <table>
                        <tr>
                            <th>User Email</th>
                            <th>Score</th>
                        </tr>
                        {#each res as attempt}
                            <tr>
                                <td>{attempt["user_email"]}</td>
                                <td>{attempt["score"]}</td>
                            </tr>
                        {/each}
                    </table>
                {/if}
            {/await}
        {:else if chosen_id != ""}
            <h1>You are not the creator of this quiz!</h1>
        {/if}
    {/await}
    <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
</div>

<style>
    .container {
        display: flex;
        flex-direction: column;

        color: white;

        width: 40%;
        height: 70%;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;

        text-align: center;
    }

    #quizIdSelector {
        font-size: 40px;
        text-align: center;
        width: 80%;
        margin-inline: auto;
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 20px;
    }

    table {
        width: 100%;
        border-spacing: 0;
        font-size: 20px;
    }

    td,
    th {
        background-color: rgb(128 128 128 / 20%);
        backdrop-filter: blur(15px);
        border: 1.5px solid #ac73ff;
        padding: 20px;
    }

    tr:first-child > :first-child {
        border-top-left-radius: 10px;
    }

    tr:first-child > :last-child {
        border-top-right-radius: 10px;
    }

    tr:last-child > :first-child {
        border-bottom-left-radius: 10px;
    }
    tr:last-child > :last-child {
        border-bottom-right-radius: 10px;
    }

    #backBtn {
        padding: 20px;
        margin-top: 50px;
        margin-inline: auto;
    }

    button {
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
