<script>
    import AttemptQuestion from "./AttemptQuestion.svelte";
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let user_email;

    const getQuestions = function (quiz_id) {
        // Make the GET request using fetch
        return fetch(
            `http://localhost/quizzeria/backend/quizAppAPI/getQuiz.php?quiz_id=${quiz_id}&user_email=${user_email}`
        )
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

    let user_answers = [];
    const update_user_answers = function (event) {
        user_answers[event.detail.question_number] = event.detail.selectedOption;
    };

    const getScore = function () {
        let score = 0;
        for (let i = 0; i < user_answers.length; i++) {
            if (user_answers[i]) {
                score++;
            }
        }
        return score;
    };

    const addScoreToDatabase = function () {
        let postData = {
            user_email: user_email,
            quiz_id: quizID,
            score: getScore(),
        };
        return fetch("http://localhost/quizzeria/backend/quizAppAPI/newAttempt.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json", // Specify the content type as JSON
            },
            body: JSON.stringify(postData), // Convert the data to JSON format
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                return data;
            })
            .catch((error) => {
                console.error("There was a problem with the fetch operation:", error);
            });
    };

    let quizStatus = 1; // 1 -> Take quiz ID || 2 -> Show Quiz || 3 -> Show score
    let quizID;
</script>

{#if quizStatus == 1}
    <div id="attemptQuiz">
        <input id="numInput" type="number" bind:value={quizID} />
        <button id="startBtn" on:click={() => (quizStatus = 2)}>Start Quiz</button>
        <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
    </div>
{:else if quizStatus == 2}
    {#await getQuestions(quizID)}
        <h1 class="responseMsg">Fetching Data...</h1>
    {:then response}
        {#if response["msg"]}
            <h1 class="responseMsg">{response["msg"]}</h1>
        {:else}
            <div id="quizContainer">
                {#each response as question}
                    <AttemptQuestion
                        {...question}
                        question_number={response.indexOf(question)}
                        on:updateAnswer={update_user_answers}
                    />
                {/each}
            </div>
            <button
                id="submitBtn"
                on:click={() => {
                    quizStatus = 3;
                }}>Submit Quiz</button
            >
        {/if}
        <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
    {/await}
{:else if quizStatus == 3}
    {#await addScoreToDatabase()}
        <h1 class="responseMsg">Querying Database...</h1>
    {:then response}
        <h1 class="responseMsg">{response["msg"]}</h1>
    {/await}
    <button on:click={() => dispatch("goBack")} id="backBtn">Go Back</button>
{/if}

<style>
    #attemptQuiz,
    .responseMsg {
        display: flex;
        flex-direction: column;

        /* background-color: red; */
        color: white;

        width: 40%;
        height: 200px;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;

        margin: auto;

        text-align: center;
    }

    #numInput {
        font-size: 40px;
        text-align: center;
        width: 80%;
        margin-inline: auto;
        margin-bottom: 20px;
        padding: 20px;
        border-radius: 20px;
    }

    #startBtn {
        width: 50%;
        padding-block: 15px;
        padding-inline: 20px;
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

    #quizContainer {
        width: 50%;
        margin-inline: auto;
        margin-top: 10px;
    }

    #submitBtn,
    #backBtn {
        padding: 20px;
        margin-top: 10px;
        margin-inline: auto;
    }
</style>
